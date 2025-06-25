<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    //
    protected $fillable = ['name', 'email', 'phone'];


    /**
     * Get all shoots for this client
     */

    public function shoots(): HasMany
    {
        return $this->hasMany(Shoot::class);
    }
}
