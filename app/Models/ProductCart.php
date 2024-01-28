<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','product_id','color','size','qty','price'];

    public function products(){
        return $this->belongsTo(Product::class);
    }
}