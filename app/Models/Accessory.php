<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    protected $fillable = [
        'productId', 'material', 'brand', 'size', 'weight'
    ];
    public function product()
    {
        return $this->belongsTo(GymProduct::class, 'productId', 'productId');
    }
}
