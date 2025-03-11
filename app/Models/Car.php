<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'price_per_day',
        'is_available',
    ];
    public function rentals() {
        return $this->hasMany(Rental::class);
    }
}
