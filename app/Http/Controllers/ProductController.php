<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductAttributeValue;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $this->data['products'] = Product::active()->paginate(9);
        // var_dump($this->data);
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
            //panggil atribute warna
            $this->data['colors'] = ProductAttributeValue::getAttributeOptions($product, 'color')->pluck('text_value', 'text_value');
			$this->data['sizes'] = ProductAttributeValue::getAttributeOptions($product, 'size')->pluck('text_value', 'text_value');
        }
        $this->data['product'] = $product;
        return $this->load_theme('products.show',$this->data);
    }

}
