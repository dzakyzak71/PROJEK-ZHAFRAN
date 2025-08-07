<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IpLog extends Model
{
    protected $fillable = [
        'user_id', 'ip', 'city', 'region', 'country', 'lat', 'lon'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}