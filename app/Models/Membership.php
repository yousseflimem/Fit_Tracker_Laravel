<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
         'userid','typeId', 'startDate', 'endDate', 'status'
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
