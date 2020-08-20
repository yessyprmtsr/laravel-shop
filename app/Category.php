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
}
