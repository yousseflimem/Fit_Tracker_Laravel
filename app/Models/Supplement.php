<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{
    protected $fillable = [
        'name', 'price', 'description'
    ];
    public function product()
    {
        return $this->belongsTo(GymProduct::class, 'productId', 'productId');
    }
}
