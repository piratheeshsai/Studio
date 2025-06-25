<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShootPackage extends Model
{
    //
    protected $fillable = [
        'price', // Package price
        'description', // Optional description
        'image_limit', // Optional: how many images included
    ];

    /**
     * Get all shoots using this package
     */
    public function shoots(): HasMany
    {
        return $this->hasMany(Shoot::class);
    }
}
