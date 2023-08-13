<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Congregation extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id_card',    
        
        'nama_lengkap',
        'jenis_kelamin',
        'kelas',
        'tgl_lahir',
        'alamat',
        'no_wa',
        'hobi',
    ];
    
    
    protected $dates = [
        'tgl_lahir',
        'created_at',
        'updated_at',
        'deleted_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/congregations/'.$this->getKey());
    }
}
