<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
		'parent_id',
		'user_id',
		'sku',
		'type',
		'name',
		'slug',
		'price',
		'weight',
		'length',
		'width',
		'height',
		'short_description',
		'description',
		'status',
    ];
    //relasi ke user
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function categories(){
        return $this->belongsToMany('App\Category', 'product_categories'); //yang kedua nama tabel penghubung
    }
    //relasi ke product images
    public function productImages(){
        return $this->hasMany('App\ProductImage');
    }
    public static function statuses(){
        return [
            0 => 'draf',
            1 => 'active',
            2 => 'deactive',
        ];
    }
}
