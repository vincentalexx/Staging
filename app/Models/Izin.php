<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Izin extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nama',
        'congregation_id',
        'angkatan',
        'kegiatan',
        'tgl_kegiatan',
        'keterangan',
        'alasan',
    ];
    
    
    protected $dates = [
        'tgl_kegiatan',
        'created_at',
        'updated_at',
        'deleted_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/izin/'.$this->getKey());
    }

    public function congregationAttendance() 
    {
        return $this->hasMany(CongregationAttendance::class);
    }
    
    public function discipleshipDetail()
    {
        return $this->belongsToMany(DiscipleshipDetail::class);
    }
}
