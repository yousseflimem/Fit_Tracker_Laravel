<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $primaryKey = 'userid';
    public $incrementing = true;

    protected $fillable = [
        'username', 'admin', 'passwordHash', 'role', 'createdAt'
    ];

    public function membership()
    {
        return $this->hasOne(Membership::class, 'userid', 'userid');
    }

    public function purchasedProducts()
    {
        return $this->belongsToMany(GymProduct::class, 'gym_product_user', 'userid', 'productId');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'userid', 'userid');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
