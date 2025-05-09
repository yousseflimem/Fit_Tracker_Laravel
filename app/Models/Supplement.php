<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Supplement extends Model
{   
    use HasFactory;
    protected $primaryKey = 'productId';
    public $incrementing = true;
    protected $fillable = [
        'name', 'price', 'description'
    ];
    public function product()
    {
        return $this->belongsTo(GymProduct::class, 'productId', 'productId');
    }
}
