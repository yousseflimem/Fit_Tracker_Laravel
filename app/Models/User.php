<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    const CREATED_AT = 'createrat';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];
     public function membership()
    {
        return $this->hasOne(Membership::class, 'userid', 'userid');
    }

    public function purchasedProducts()
    {
        return $this->hasMany(PurchasedProduct::class, 'userid', 'userid');
    }

    public function gymProducts()
    {
        return $this->hasMany(GymProduct::class, 'userid', 'userid');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'userid', 'userid');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
