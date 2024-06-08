<?php

namespace App\Models\users\product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    public $incrementing = false; // ID не автоинкрементное
    protected $table = 'product_ref';
    protected $keyType = 'string'; // Тип ключа - строка
    protected $fillable = [
        'created_by', 
        'created_at', 
        'update_at', 
        'activity', 
        'category_id', 
        'sub_category_id', 
        'photo_src', 
        'name',
        'chemical_class_id',
        'active_substance_id',
        'price',
        'discount',
        'deactivity_at'
    ];
}
