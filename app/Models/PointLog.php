<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_penginput',
        'target_card_id',
        'keterangan', // penambahan / pengurangan point
        'jumlah_point',
    ];
}
