<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipType extends Model
{
    protected $primaryKey = 'typeId';
    public $incrementing = true;
    protected $fillable = [
        'name', 'price', 'durationInDays'
    ];

    public function memberships()
    {
        return $this->hasMany(Membership::class, 'typeId', 'typeId');
    }
}
