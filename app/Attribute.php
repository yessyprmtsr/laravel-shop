<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'code',
        'name',
        'type',
        'validation',
        'is_required',
        'is_unique',
        'is_filterable',
        'is_configurable',
    ];

    public static function types(){
        //definisi tipe dari atributes
        return [
            'text' => 'Text',
            'textarea' => 'Textarea',
            'price' => 'Price',
            'boolean' => 'Boolean',
            'select' => 'Select', //support atribute color,warna,size
            'datetime' => 'Datetime',
            'date' => 'Date',
        ];
    }
    public static function booleanOptions()
    {
        return [
            1 => 'Yes',
            0 => 'No',
        ];
    }
    public static function validations()
    {
        return [
            'number' => 'Number',
            'decimal' => 'Decimal',
            'email' => 'Email',
            'url' => 'URL',
        ];
    }
    //relasi ke attributeoption
    public function attributeOptions()
    {
        return $this->hasMany('App\SSSAttributeOption');
    }

}
