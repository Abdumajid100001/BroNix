<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'color',
    ];

    
    public function businesses()
    {
        return $this->hasMany(Business::class, 'business_type_id');
    }
}