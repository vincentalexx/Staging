<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CongregationAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'congregation_id',

        'tanggal',
        'jam_datang',
        'keterangan',
        'tempat_kebaktian',
    ];

    public function congregation() 
    {
        return $this->belongsTo(Congregation::class);
    }
}
