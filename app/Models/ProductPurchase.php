<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price_at_purchase',
        'purchase_date',
        // Any other fields you want to allow mass assignment for
    ];
     public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function product()
    {
        return $this->belongsTo(GymProduct::class, 'product_id');
        
    }
    protected $casts = [
        'purchase_date' => 'datetime',
    ];
}
