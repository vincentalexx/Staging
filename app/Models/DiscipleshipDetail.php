<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscipleshipDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'discipleship_id',
        'divisi',
        'judul',
        'tanggal',
        'keterangan',

        'created_by',
        'updated_by',
    ];
    
    
    protected $dates = [
        'created_at',
        'deleted_at',
        'tanggal',
        'updated_at',
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/discipleship-details/'.$this->getKey());
    }

    public function congregation()
    {
        return $this->belongsToMany(Congregation::class);
    }
}
