<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductAttributeValue;
use Illuminate\Http\Request;
use Str;

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        //definisi varibel dulu untuk search
        $this->data['q'] = null;
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
