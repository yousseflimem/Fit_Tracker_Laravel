<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Membership extends Model
{
    use HasFactory;
    protected $primaryKey = 'membershipId';
    public $incrementing = true;

    protected $fillable = [
        'userid', 'typeId', 'startDate', 'endDate', 'status'
    ];



    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'userid');
    }

    public function type()
    {
        return $this->belongsTo(MembershipType::class, 'typeId', 'typeId');
    }
}
