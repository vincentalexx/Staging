<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'budget_id',

        'nama_budget',
        'jumlah_orang_maksimum',
        'budget',
        'total',
        'is_used',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function budget() {
        return $this->belongsTo(Budget::class);
    }
}
