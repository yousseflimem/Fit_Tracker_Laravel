<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchasedProduct extends Model
{
    protected $fillable = [
        'userid',
        'productid',
        'purchase_date',
        'quantity',
        'price_at_purchase',
        'purchase_date',
        // Any other fields you want to allow mass assignment for
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    public function product()
    {
        return $this->belongsTo(GymProduct::class, 'productid');
        
    }
}
