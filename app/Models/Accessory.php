<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GymProduct;

class Accessory extends Model
{
    protected $fillable = [
         'productId','material', 'brand', 'size', 'weight'
    ];
    public $timestamps = false;
    public function product()
    {
        return $this->belongsTo(GymProduct::class, 'productId', 'productId');
    }
}
