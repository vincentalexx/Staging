<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discipleship extends Model
{
    protected $fillable = [
        'divisi',
        'nama_pembinaan',
        'hari',

        'created_by',
        'updated_by',
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/discipleships/'.$this->getKey());
    }
}
