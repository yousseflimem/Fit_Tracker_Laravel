<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Review extends Model
{   
    use HasFactory;
    protected $primaryKey = 'reviewId';
    public $incrementing = true;
    protected $fillable = [
        'userid', 'productId', 'rating', 'comment', 'createdAt'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'userid');
    }

    public function product()
    {
        return $this->belongsTo(GymProduct::class, 'productId', 'productId');
    }
}
