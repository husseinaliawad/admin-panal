<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    
    protected $fillable =[
        'category_id',
        'brand_id',
        'name',
        'slug',
        'images',
         'description',
         'price',
         'is_active',
         'is_featured',
         'is_stock',
         'on_sale',
        ];
  

        protected $casts =[
            'images' => 'array',
        ];
    public function category(){
        return $this->belongsTo(category::class);
    } public function brand(){
        return $this->belongsTo(Brand::class);
    } public function orderItem(){
        return $this->hasMany(OrderItem::class);
   
}
}
