<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Accessory extends Model
{
    use HasFactory;
    protected $primaryKey = 'productId';
    public $incrementing = true;
    protected $fillable = [
        'productId', 'material', 'brand', 'size', 'weight'
    ];
    public function product()
    {
        return $this->belongsTo(GymProduct::class, 'productId', 'productId');
    }
}

