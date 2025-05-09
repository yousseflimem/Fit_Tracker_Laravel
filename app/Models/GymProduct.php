<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Add this

class GymProduct extends Model
{
    use HasFactory; // Add this
     protected $fillable = [
        'id', 'name', 'description', 'price', 'category', 'stock'
    ];
    
    public function supplement()
    {
        return $this->hasOne(Supplement::class, 'productId', 'productId');
    }

    public function clothing()
    {
        return $this->hasOne(Clothing::class, 'productId', 'productId');
    }

    public function accessory()
    {
        return $this->hasOne(Accessory::class, 'productId', 'productId');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'productId', 'productId');
    }
}
