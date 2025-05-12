<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // Define custom timestamps

    // Disable automatic timestamps if you're using custom ones
    public $timestamps = true;

    // Define which columns are mass-assignable
    protected $fillable = [
        'userid', 'productId', 'rating', 'comment', 'createdAt', 'updatedAt'
    ];

    // Relationship to User
    public function user()
    {
        // Define the foreign key in the 'reviews' table (userid) and the local key in 'users' table (id)
        return $this->belongsTo(User::class, 'userid');
    }

    // Relationship to GymProduct
    public function product()
    {
        // Define the foreign key in the 'reviews' table (productId) and the local key in 'gym_products' table (id)
        return $this->belongsTo(GymProduct::class, 'productId', 'id');
    }
}
