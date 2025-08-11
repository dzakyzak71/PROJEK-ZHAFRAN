<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanImage extends Model
{
    protected $fillable = ['laporan_id', 'filename'];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}