<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shoot extends Model
{
    //
    protected $fillable = [
        'client_id',
        'title',
        'type', // e.g., Wedding, Birthday
        'shoot_date',
        'shoot_package_id',
    ];

    public function client():BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(ShootPackage::class, 'shoot_package_id');
    }
}
