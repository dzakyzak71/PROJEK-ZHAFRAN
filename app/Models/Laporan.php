<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laporan extends Model
{
    protected $fillable = [
        'user_id',
        'isi',
        'gambar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
