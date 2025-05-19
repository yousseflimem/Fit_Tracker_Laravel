<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GymProduct extends Model
{
    protected $fillable = [
         'name', 'description', 'price', 'category', 'stock','imgURL'
    ];
     public function supplement()
    {
        return $this->hasOne(Supplement::class, 'productId');
    }

    public function clothing()
    {
        return $this->hasOne(Clothing::class, 'productId');
    }

    public function accessory()
    {
        return $this->hasOne(Accessory::class, 'productId');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'productId');
    }
    public function productable()
    {
        return $this->morphTo();
    }
     
}
