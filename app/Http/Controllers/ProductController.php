<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductAttributeValue;
use App\Category;
use App\AttributeOption;
use Illuminate\Http\Request;
use Str;

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        //definisi varibel dulu untuk search
        $this->data['q'] = null;
        //nampilin kategori
        $this->data['categories'] = Category::parentCategories()
        ->orderBy('name', 'asc')
        ->get();
        //filter harga nentuin max sama min harga dullu
        $this->data['minPrice'] = Product::min('price');
		$this->data['maxPrice'] = Product::max('price');
        //filter color
        $this->data['colors'] = AttributeOption::whereHas('attribute', function ($query) { //cari attribute di attrbibute option
                                $query  ->where('code','color') //cari color
                                        ->where('is_filterable',1); //is filterablenya adalah satu/ada
                                })->orderBy('name','ASC')->get();
        //filter sizes
        $this->data['sizes'] = AttributeOption::whereHas('attribute', function ($query) { //cari attribute di attrbibute option
            $query  ->where('code','size') //cari color
                    ->where('is_filterable',1); //is filterablenya adalah satu/ada
            })->orderBy('name','ASC')->get();
        //sorting dari tanggal produk dikeluarkan
		$this->data['sorts'] = [
			url('products') => 'Default',
			url('products?sort=created_at-desc') => 'Newest to Oldest',
			url('products?sort=created_at-asc') => 'Oldest to Newest',
		];

		$this->data['selectedSort'] = url('products');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        //gunakan query builder laravel untuk search
        $products = Product::active();
        //method untuk filter search, filtering, sorting products
        $products = $this->searchProducts($products, $request);
		$products = $this->filterProductsByPriceRange($products, $request);
		$products = $this->filterProductsByAttribute($products, $request);
        $products = $this->sortProducts($products, $request);
        $this->data['products'] = $products->paginate(9);
        //ambil template
        return $this->load_theme('products.index', $this->data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Display the specified resource.
     *
     * @param  string product  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::active()->where('slug',$slug)->first();
        //cek apakah ada product
        if(!$product){
            return redirect()->route('userproduct');
        }
        //cek configurable produk
        if($product->type == "configurable"){
            //panggil atribute warna dan sizes
            $this->data['colors'] = ProductAttributeValue::getAttributeOptions($product, 'color')->pluck('text_value', 'text_value');
			$this->data['sizes'] = ProductAttributeValue::getAttributeOptions($product, 'size')->pluck('text_value', 'text_value');
        }
        $this->data['product'] = $product;
        return $this->load_theme('products.show',$this->data);
    }
    private function searchProducts($products,$request){

        //menangkap inputan dari user
        if ($q = $request->query('q')) {
			$q = str_replace('-', ' ', Str::slug($q));
			 //ngehilangin karakter

            //cari yang sama
            $products = $products->whereRaw('MATCH(name, slug, short_description, description) AGAINST (? IN NATURAL LANGUAGE MODE)', [$q]);
            //kalo awal query null,setelah user input maka request
            $this->data['q'] = $q;
        }
           //nmenangkap inputan query stringuntuk category
            if ($categorySlug = $request->query('category')) {
                $category = Category::where('slug', $categorySlug)->firstOrFail();
                //nampilin anak kategori
                $childIds = Category::childIds($category->id);
                $categoryIds = array_merge([$category->id], $childIds); //digabungkan

                $products = $products->whereHas(
                    'categories',
                    function ($query) use ($categoryIds) {
                        $query->whereIn('categories.id', $categoryIds);
                    }
                );
            }
            return $products;
    }
    private function filterProductsByPriceRange($products, $request)
	{
             //atur filter produk sesuai rentang harga
		$lowPrice = null;
		$highPrice = null;
           //dapatkan query
		if ($priceSlider = $request->query('price')) {
            //agar tidak ada simbol -
			$prices = explode('-', $priceSlider);
            //akan dapatkan lowprice dan high
			$lowPrice = !empty($prices[0]) ? (float)$prices[0] : $this->data['minPrice']; //kalo tidak kososng dan index 0 akan assign float, kalo gaada quey ato filter defaultnya adalah main class dari product yang ada di database
			$highPrice = !empty($prices[1]) ? (float)$prices[1] : $this->data['maxPrice'];

            //jika lowprice dan highprice sudah diisikan
			if ($lowPrice && $highPrice) {
				$products = $products->where('price', '>=', $lowPrice)
					->where('price', '<=', $highPrice)
					->orWhereHas( //untuk configurable product
						'variants', //cek configurable product
						function ($query) use ($lowPrice, $highPrice) {
							$query->where('price', '>=', $lowPrice)
								->where('price', '<=', $highPrice);
						}
					);

				$this->data['minPrice'] = $lowPrice;
				$this->data['maxPrice'] = $highPrice;
			}
		}

		return $products;
	}
    private function filterProductsByAttribute($products, $request)
	{
        //product hanya nampilin parent aja jadi kudu ditambahi kolom product_attributes_value dengan kolom parent id jadi ada relasi lgsung ke attribute value
        //ambil attribute option id
		if ($attributeOptionID = $request->query('option')) {
			$attributeOption = AttributeOption::findOrFail($attributeOptionID);
               //query ke products
            //ketika user memilih attribute option contoh 5 maka akan mencari ke product attribute values yang dikaitkan ke attribute id lalu dengan textvalue di product attribute values
			$products = $products->whereHas(
				'ProductAttributeValues',
				function ($query) use ($attributeOption) {
					$query->where('attribute_id', $attributeOption->attribute_id)
						->where('text_value', $attributeOption->name);
				}
			);
		}

		return $products;
    }
    private function sortProducts($products, $request)
	{

        //untuk fitur sorting
        //perlu ngehilangin spasi di url ketika
		if ($sort = preg_replace('/\s+/', '', $request->query('sort'))) {
			$availableSorts = ['created_at']; //definisi variable sort hanya price samaa waktu
			$availableOrder = ['asc', 'desc']; //availablenya cuma ascending dan descending
			$sortAndOrder = explode('-', $sort); //hilangin simbol -

			$sortBy = strtolower($sortAndOrder[0]); //mulai hutuf kecil semuan dan index ke 0
			$orderBy = strtolower($sortAndOrder[1]); // mulai huruf kecil semua dgn index ke 1
             //query data
            // cek jika sort by dan available sort sesuai dan order bynya valid maka ngembaliin data products
			if (in_array($sortBy, $availableSorts) && in_array($orderBy, $availableOrder)) {
				$products = $products->orderBy($sortBy, $orderBy);
			}

			$this->data['selectedSort'] = url('products?sort='. $sort);
		}

		return $products;
	}
}
