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
        // var_dump($this->data);

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
        //atur filter produk sesuai rentang harga
        $lowPrice =null;
        $highPrice = null;
        //dapatkan query
        if ($priceSlider = $request->query('price')) {
            //agar tidak ada simbol
			$prices = explode('-', $priceSlider);
            //akan dapatkan lowprice dan high
			$lowPrice = !empty($prices[0]) ? (float)$prices[0] : $this->data['minPrice']; //kalo tidak kososng dan index 0 akan assign float, kalo gaada quey ato filter defaultnya adalah main class dari product yang ada di database
			$highPrice = !empty($prices[1]) ? (float)$prices[1] : $this->data['maxPrice'];

            //jika lowprice dan highprice sudah diisikan
			if ($lowPrice && $highPrice) {
				$products = $products->where('price', '>=', $lowPrice) //
					->where('price', '<=', $highPrice)
					->orWhereHas( //untuk configurable product
						'variants', //cek untuk configurable product
						function ($query) use ($lowPrice, $highPrice) {
							$query->where('price', '>=', $lowPrice)
								->where('price', '<=', $highPrice);
						}
					);

				$this->data['minPrice'] = $lowPrice;
				$this->data['maxPrice'] = $highPrice;
			}
        }

        //ambil attribute option id
        if($attributeOptionID = $request->query('option')){
            $attribtueOption = AttributeOption::findorFail($attributeOptionID);

            //query ke products
            //ketika user memilih attribute option contoh 5 maka akan mencari ke product attribute values yang dikaitkan ke attribute id lalu dengan textvalue di product attribute values
            $products = $products->whereHas('ProductAttributeValues', function ($query) use ($attribtueOption){
                        $query->where('attribute_id',$attribtueOption->attribute_id)
                                ->where('text_value',$attribtueOption->name);
            });
            //product hanya nampilin parent aja jadi kudu ditambahi kolom product_attributes_value dengan kolom parent id jadi ada relasi lgsung ke attribute value
        }

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

}
