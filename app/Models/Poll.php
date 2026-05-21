<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = ['business_id', 'token', 'positive_votes', 'is_booked'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
