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

    /**
     * Связь «Один ко многим» с моделью Business
     */
    public function businesses()
    {
        // Теперь здесь указано строгое и правильное имя колонки в базе данных
        return $this->hasMany(Business::class, 'business_type_id');
    }
}