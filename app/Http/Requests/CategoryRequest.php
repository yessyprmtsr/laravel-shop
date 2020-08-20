<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //women jacket
        //men jacket
        //blazzer

        //validasi ketika user input category dg definisi parent id
        $parentId = (int) $this->get('parent_id');
        $id = (int) $this->get('id');

        if($this->method() == 'PUT'){
            if($parentId > 0){
                $name = 'required:unique:categories,name,'.$id.',id,parent_id,'.$parentId;
            }
            //user tidak memberikan parent id
            else {
                $name = 'required|unique:categories,name,'.$id;
            }
            $slug = 'unique:categories,slug'.$id;
        } //membuat kategori baru
        else {
            $name = 'required|unique:categories,name,NULL,id,parent_id,'.$parentId;
            $slug = 'unique:categories,slug';
        }
        return [
        'name' => $name,
        'slug' => $slug
        ];
    }
}