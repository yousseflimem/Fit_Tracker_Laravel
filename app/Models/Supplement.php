<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{
    protected $fillable = [
        'productId','flavor', 'weight', 'form'
    ];
     public $timestamps = false;
    public function product()
    {
        return $this->belongsTo(GymProduct::class, 'productId');
    }
}
