<?php

namespace App\Http\Controllers\Admin;

use App\Attribute;
use App\AttributeOption;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductImageRequest;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\ProductAttributeValue;
use App\ProductImage;
use App\ProductInventory;
use App\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    use Authorizable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->data['statuses'] = Product::statuses();
        $this->data['types'] = Product::types();

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
        $categories = Category::orderBy('name', 'ASC')->get();
        $configurableAttributes = $this->getConfigurableAttributes();

        $this->data['categories'] = $categories->toArray();
        $this->data['product'] = null;
        $this->data['productID'] = 0;
        $this->data['categoryIDs'] = [];
        $this->data['configurableAttributes'] = $configurableAttributes;

        return view('admin.products.form', $this->data);
    }

    private function getConfigurableAttributes()
    {
        return Attribute::where('is_configurable', true)->get();
    }
    //looping atribut trus ambil nama trus jadi nama varia produk
    private function convertVariantAsName($variant)
    {
        $variantName = '';

        foreach (array_keys($variant) as $key => $code) {
            $attributeOptionID = $variant[$code];
            $attributeOption = AttributeOption::find($attributeOptionID);

            if ($attributeOption) {
                $variantName .= ' - ' . $attributeOption->name;
            }
        }
        return $variantName;
    }

    private function generateProductVariants($product,$params){
        //panggil configurable
        $configurableAttributes = $this->getConfigurableAttributes();
        $variantAttributes = [];
        foreach($configurableAttributes as $attributes){
            $variantAttributes[$attributes->code] = $params[$attributes->code];
        }
        //generate varian yang terjadi dan terbuat dari kombinasi attribut dan pemanggilan atribut kombinasi
        $variants = $this->generateAttributeCombinations($variantAttributes);
        //simpan ke table produk
        //tipe varian simple karna merupakan anak produk dari produk llain
        if($variants) {
            foreach($variants as $variant){
                $variantParams = [
                    'parent_id' => $product->id,
                    'user_id' => Auth::user()->id,
                    'sku' => $product->sku . '-' .implode('-', array_values($variant)),
                    'type' => 'simple',
                    'name' => $product->name . $this->convertVariantAsName($variant),
                ];
                $variantParams['slug'] = Str::slug($variantParams['name']);
                $newProductVariant = Product::create($variantParams);

                $categoryIds = !empty($params['category_ids']) ? $params['category_ids'] : [];
                $newProductVariant->categories()->sync($categoryIds);

                $this->saveProductAttributeValues($newProductVariant, $variant, $product->id);
            }
        }
    }
    //menyimpan value dari atribut yang dipilih
    private function saveProductAttributeValues($product, $variant, $parentProductID)
    {
        foreach (array_values($variant) as $attributeOptionID) {
            $attributeOption = AttributeOption::find($attributeOptionID);

            $attributeValueParams = [
                'parent_product_id' => $parentProductID,
                'product_id' => $product->id,
                'attribute_id' => $attributeOption->attribute_id,
                'text_value' => $attributeOption->name,
            ];

            ProductAttributeValue::create($attributeValueParams);
         }
    }
    //aray kombinasi atribut menjadi varian produk
    private function generateAttributeCombinations($arrays){
        $result = [[]];
        foreach ($arrays as $property => $property_values) {
            $tmp = [];
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, array($property => $property_value));
                }
            }
            $result = $tmp;
        }
        return $result;

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

        //definisikann proses penyimpanan data product
        $product = DB::transaction(function () use ($params)
        {
            //tangkap kategori id yang dipilih
            $categoryIds = !empty($params['category_ids']) ? $params['category_ids'] : [];
            //simpan data produk yg ditambahakn
            $product = Product::create($params);
            //relasi produk dan kategori yg dipilih user
            $product->categories()->sync($params['category_ids']);


            //misal user menambah tipe configurable
            if($params['type'] == 'configurable'){
                //generate varian produk
                $this->generateProductVariants($product, $params);
            }
            return $product;
        });
        if ($product){
            Session::flash('success','Data Product has been saved');
        } else {
            Session::flash('error','Data Product could not be saved');
        }
         return redirect('admin/products/'. $product->id .'/edit/');

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
        if(empty($id)){
            return redirect()->route('products.create');
        }

        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name','ASC')->get();

        $this->data['categories'] = $categories->toArray();
        $this->data['product'] = $product;
        $this->data['productID'] = $product->id;
        $this->data['categoryIDs'] = $product->categories->pluck('id')->toArray();

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
        $saved = DB::transaction(function() use ($product, $params) {
            $categoryIds = !empty($params['category_ids']) ? $params['category_ids'] : [];
            $product->update($params);
            $product->categories()->sync($categoryIds);

            if ($product->type == 'configurable') {
                $this->updateProductVariants($params);
            } else {
                ProductInventory::updateOrCreate(['product_id' => $product->id], ['qty' => $params['qty']]);
            }

            return true;
        });

        if ($saved) {
            Session::flash('success', 'Product has been saved');
        } else {
            Session::flash('error', 'Product could not be saved');
        }

        return redirect()->route('products.index');
        }

        private function updateProductVariants($params)
        {
            if ($params['variants']) {
                foreach ($params['variants'] as $productParams) {
                    $product = Product::find($productParams['id']);
                    $product->update($productParams);

                    $product->status = $params['status'];
                    $product->save();

                    ProductInventory::updateOrCreate(['product_id' => $product->id], ['qty' => $productParams['qty']]);
                }
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
        $product  = Product::findOrFail($id);

        if ($product->delete()) {
            Session::flash('success', 'Products has been deleted');
        }
        return redirect()->route('products.index');
    }
    public function images($id){

        if (empty($id)) {
            return redirect()->route('products.create');
        }
        $product = Product::findOrFail($id);

        $this->data['productID'] = $product->id;
        $this->data['productImages'] = $product->productImages;

        return view('admin.products.images', $this->data);
    }

    public function add_image($id){
        if (empty($id)) {
            return redirect()->route('products.index');
        }

        $product = Product::findOrFail($id);

        $this->data['productID'] = $product->id;
        $this->data['product'] = $product;

        return view('admin.products.image_form', $this->data);
    }
    public function upload_image(ProductImageRequest $request, $id){
        $product = Product::findOrFail($id);
        //pengecekan ada file images atau tidak
        if($request->has('image')){
            $image = $request->file('image');
            //buat nama file setelah diupload
            $name = $product->slug .'_'. time();
            //buat file name serta extensionnya
            $fileName = $name . '.' . $image->getClientOriginalExtension();
            //definisi folder penyimpanan
            $folder = '/uploads/images';
            //user menyimpan ke file direktori dri app
            $filePath = $image->storeAs($folder,$fileName, 'public');
            //variabel untuk keperluan penyimpanan data ke table
            $params = [
                'product_id' => $product->id,
                'path' => $filePath,
            ];
            if(ProductImage::create($params)){
                Session::flash('success', 'Image has been uploaded');
            } else {
                Session::flash('error', 'Image could not be uploaded');
            }
            return redirect('admin/products/'.$id.'/images');
        }

    }
    public function remove_image($id)
    {

        $image = ProductImage::findOrFail($id);
        Storage::disk('public')->delete($image->path);
        if ($image->delete()) {
            Session::flash('success', 'Image has been deleted');
        }

        return redirect('admin/products/' . $image->product->id . '/images');
    }
}
