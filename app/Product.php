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
    public function productInventory(){
        return $this->hasOne('App\ProductInventory');
    }
    public function categories(){
        return $this->belongsToMany('App\Category', 'product_categories'); //yang kedua nama tabel penghubung
    }
    //product akan relasi dg producct
    public function variants(){
        return $this->hasMany('App\Product', 'parent_id');
    }
    //relasi ke product parentnya
    public function parent(){
        return $this->belongsTo('App\Product','parent_id');
    }
    //relasi ke attributes values
    public function productAttributeValues(){
        return $this->hasMany('App\ProductAttributeValue');
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
    public static function types(){
        return [
            'simple' => 'Simple',
            'configurable' => 'Configurable',
        ];
    }
}
