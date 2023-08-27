<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetUsage extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'created_by',
        'updated_by',
        'budget_id',
        'budget_detail_id',

        'divisi',
        'tanggal',
        'jenis_budget',
        'deskripsi',
        'jumlah_orang',
        'total',
        'reimburs',
    ];
    
    
    protected $dates = [
        'tanggal',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/budget-usages/'.$this->getKey());
    }
}
