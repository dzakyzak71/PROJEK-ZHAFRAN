<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'judul',
        'isi',
        'status', // tambahkan
    ];

    public function images()
    {
        return $this->hasMany(LaporanImage::class);
        
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
        
    }

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function adminTujuan()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
