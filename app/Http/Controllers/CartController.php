<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class CartController extends Controller
{
    public function __construct(){
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = \Cart::getContent();
        //tampil view
        $this->data['items'] = $items;
        return $this->load_theme('carts.index',$this->data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //DATA MASIH DISIMPAN DI SESSION
        $params = $request->except('_token');
        //cari produk dulu ini induk
        $product = Product::findOrFail($params['product_id']);
        //ketika user nambahin item lalu direct lagi ke idisplay item produk tsb
        $slug = $product->slug;
        //untuk attribute
        $attribute = [];
        //cek produk apakan config apa simple
        if($product->configurable()){
            //perlu cari varian produk induk warna dan ukuran

            $product = Product::from('products as p')
				->whereRaw(
                     //trus join ke product attributes value pakek inner join dan subquery
					"p.parent_id = :parent_product_id
				        and (select pav.text_value
						from product_attribute_values pav
						join attributes a on a.id = pav.attribute_id
						where a.code = :size_code
						and pav.product_id = p.id
						limit 1
					) = :size_value
				and (select pav.text_value
						from product_attribute_values pav
						join attributes a on a.id = pav.attribute_id
						where a.code = :color_code
						and pav.product_id = p.id
						limit 1
					) = :color_value
					",
					[
                        //didapatkan produk varian yang dipilih user
						'parent_product_id' => $product->id,
						'size_code' => 'size',
						'size_value' => $params['size'],
						'color_code' => 'color',
						'color_value' => $params['color'],
					]
                )->firstOrFail();
                //jika dah ketemu produk
                $attributes['size'] = $params['size'];
                $attributes['color'] = $params['color'];
        }
        //siapkan item yg mau dimasukkan ke shopping cart
        $item = [
			'id' => $product->id, //diambil dari produk id
			'name' => $product->name, //diambil produk nama
			'price' => $product->price, //diambil dari produk harga
			'quantity' => $params['qty'], //diambil dari stok
			'attributes' => $attributes, //diambil dari attributes dair diatas
			'associatedModel' => $product, //diambil dari model yang direlasikan
        ];
        //nambahkannya ke cart
        \Cart::add($item);
        //taruh session message
        \Session::flash('success', 'Product '. $item['name'] .' has been added to cart');
        //kembali ke detail
		return redirect('/products/'. $slug);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //ambil params
        $params = $request->except('_token');
        if($items = $params['items']){
            foreach($items as $cartID => $item){
            // NOTE: as you can see by default, the quantity update is relative to its current value
            // if you want to just totally replace the quantity instead of incrementing or decrementing its current quantity value
            // you can pass an array in quantity value like so:
            \Cart::update($cartID, [
                'quantity' => [
                    'relative' => false,
                    'value' => $item['quantity']
                    ],
                ]);

            }
            \Session::flash('Success','Cart has been updated');
            return redirect()->route('cart.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //hapus
        \Cart::remove($id);
        return redirect()->route('cart.index');
    }
}
