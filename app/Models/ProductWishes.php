<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWishes extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','user_id'];
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}