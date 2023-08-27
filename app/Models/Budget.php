<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'created_by',
        'updated_by',

        'divisi',
        'nama_periode',
        'periode',
        'total_budget_awal',

        // penggunaan budget
        'total_budget_terpakai',
        'total_reimburs',
        'sisa',
        'kelebihan',
    ];
    
    protected $dates = [
        'created_at',
        'periode',
        'updated_at',
        'deleted_at',
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/budgets/'.$this->getKey());
    }

    public function budgetDetails() {
        return $this->hasMany(BudgetDetail::class);
    }
}
