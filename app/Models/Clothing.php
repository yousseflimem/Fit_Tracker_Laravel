<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clothing extends Model
{
    protected $fillable = [
        'id', 'size', 'color', 'gender', 'material'
    ];
    public function product()
    {
        return $this->belongsTo(GymProduct::class, 'productId', 'productId');
    }
}
