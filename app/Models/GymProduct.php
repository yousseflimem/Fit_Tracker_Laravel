<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GymProduct extends Model
{
    protected $primaryKey = 'productId';
    public $incrementing = true;
    protected $fillable = [
        'productId', 'name', 'description', 'price', 'category', 'stock'
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
