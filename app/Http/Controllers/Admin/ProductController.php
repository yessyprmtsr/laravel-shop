<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->data['statuses'] = Product::statuses();
    }
    public function index()
    {
         //memanggil data product
         $this->data['products'] = Product::orderBy('name','ASC')->paginate(10);
         return view('admin.products.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //ngambil data category dulu dan nampilin pilihan category
        $categories = Category::orderBy('name','ASC')->get();
        $this->data['categories'] = $categories->toArray();
        $this->data['product'] = null;
        $this->data['categoryIDs'] = [];

        return view('admin.products.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $params = $request->except('_token');
        //convert slug dri nama
        $params['slug'] = Str::slug($params['name']);
        //untuk user id
        $params['user_id'] = Auth::user()->id;

        //save data
        //variable cek berjalan atau ga
        $saved = false;
        //definisikann proses penyimpanan data product
        $saved = DB::transaction(function () use ($params)
        {
            //simpan data produk yg ditambahakn
            $product = Product::create($params);
            //relasi produk dan kategori yg dipilih user
            $product->categories()->sync($params['category_ids']);
            return true;
        });
        if ($saved){
            Session::flash('success','Data Product has been saved');
        } else {
            Session::flash('error','Data Product could not be saved');
        }
        return redirect()->route('products.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name','ASC')->get();

        $this->data['categories'] = $categories->toArray();
        $this->data['product'] = $product;
        $this->data['categoriyIDs'] = $product->categories->pluck('id')->toArray();

        return view('admin.products.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $params = $request->except('_token');
        $params['slug'] = Str::slug($params['name']);
        $product = Product::findOrFail($id);
        $saved = false;
        $saved = DB::transaction(function () use ($product, $params) {
            $product->update($params);
            $product->categories()->sync($params['category_ids']);

            return true;
        });
        if ($saved){
            Session::flash('success','Data Product has been updated');
        } else {
            Session::flash('error','Data Product could not be updated');
        }
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
