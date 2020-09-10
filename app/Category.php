<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','slug','parent_id'];
    //lewat parent id untuk membuat kategori
    //relasi untuk mendapat child/sub kategori dari category awal
    public function childs(){
        return $this->hasMany('App\Category','parent_id');
    }
    //relasi ke parent
    public function parent(){
        //setiap kategori dapat dimiliki ole parent
        return $this->belongsTo('App\Category','parent_id');
    }
    //relasi produk
    public function products(){
        return $this->belongsToMany('App\Product','product_Categories');
    }
    //bikin scope untuk nampilin kategori
    public function scopeParentCategories($query)
    {
        return $query->where('parent_id', 0); //
    }

    //untuk nampilin semua anak kategori dari anak kategori tertentu
    public static function childIds($parentId = 0) //parent awal
	{
		$categories = Category::select('id','name','parent_id')->where('parent_id', $parentId)->get()->toArray(); //mengquery parentnya apa

        //di looping trus jadiin array dan dibawah kategori induk
		$childIds = [];
		if(!empty($categories)){
			foreach($categories as $category){
				$childIds[] = $category['id'];
				$childIds = array_merge($childIds, Category::childIds($category['id']));
			}
		}

		return $childIds;
	}
}
