<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['categories'] = Category::orderBy('name', 'ASC')->paginate(10);

        return view('admin.categories.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();

        $this->data['categories'] = $categories->toArray(); //passing data ke view
        $this->data['category'] = null; //jika user input namun sudah ada
        return view('admin.categories.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $params = $request->except('_token'); //merequest simpan kecuali token
        $params['slug'] = Str::slug($params['name']); //simpan nama otomatis ke slug
        $params['parent_id'] = (int) $params['parent_id']; //sesuai inputan user

        if (Category::create($params)) {
            Session::flash('success', 'Category has been saved');
        }
        return redirect('admin/categories');
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
        $category = Category::findOrFail($id);
        $this->data['category'] = $category;
        return view('admin.categories.form',$this->data);
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
        $params = $request->except('_token'); //merequest simpan kecuali token
        $params['slug'] = Str::slug($params['name']); //simpan nama otomatis ke slug
        $category = Category::findOrFail($id); //agar data yang tidak ditemukan agar di fail
        if($category->update($params)){
            Session::flash('success','Data has been updated');
        }
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category  = Category::findOrFail($id);

        if ($category->delete()) {
            Session::flash('success', 'Category has been deleted');
        }
        return redirect()->route('categories.index');
    }
}
