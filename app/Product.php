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
        return $this->hasMany('App\Product', 'parent_id')->orderBy('price','ASC');
    }
    //relasi ke product parentnya
    public function parent(){
        return $this->belongsTo('App\Product','parent_id');
    }
    //relasi ke attributes values
    public function productAttributeValues(){
        return $this->hasMany('App\ProductAttributeValue','parent_product_id'); //relasi ke parent_product_id
    }
    //relasi ke product images
    public function productImages(){
        return $this->hasMany('App\ProductImage')->orderBy('id','DESC');
    }
    public static function statuses(){
        return [
            0 => 'draf',
            1 => 'active',
            2 => 'deactive',
        ];
    }
   public function status_label()
	{
		$statuses = $this->statuses();

	   return isset($this->status) ? $statuses[$this->status] : null;
	}
    public static function types(){
        return [
            'simple' => 'Simple',
            'configurable' => 'Configurable',
        ];
    }
    //aktifkan data ke sisi customernya
    public function scopeActive($query)
    {
        return $query->where('status', 1)
                     ->where('parent_id', NULL)
                     ->orderBy('created_at', 'DESC');
    }
    //nampilin price labelnya
    function price_label()
	{
        //apakah varian produk ada atau tidak
		return ($this->variants->count() > 0) ? $this->variants->first()->price : $this->price;
	}

}
