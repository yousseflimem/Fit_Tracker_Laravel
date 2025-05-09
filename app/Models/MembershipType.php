<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class MembershipType extends Model
{
    use HasFactory;
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
