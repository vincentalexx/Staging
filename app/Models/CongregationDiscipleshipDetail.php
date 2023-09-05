<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CongregationDiscipleshipDetail extends Model
{
    use HasFactory;

    protected $table = "congregation_discipleship_detail";

    protected $fillable = [
        'congregation_id',
        'discipleship_detail_id',

        'keterangan',
        'alasan',
    ];

    public function congregation()
    {
        return $this->belongsTo(Congregation::class);
    }

    public function discipleshipDetail()
    {
        return $this->belongsTo(DiscipleshipDetail::class);
    }
}
