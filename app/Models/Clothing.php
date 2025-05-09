<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Clothing extends Model
{
    use HasFactory;
    public $incrementing = true;
    protected $fillable = [
        'id', 'size', 'color', 'gender', 'material'
    ];
    public function product()
    {
        return $this->belongsTo(GymProduct::class, 'productId', 'productId');
    }
}
