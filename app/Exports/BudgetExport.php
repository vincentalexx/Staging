<?php

namespace App\Exports;

use App\Models\Budget;
use App\Models\BudgetUsage;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class BudgetExport implements FromView
{
    protected $id;
    
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $budget = Budget::find($this->id);
        $budgetUsages = BudgetUsage::with('budgetDetail')
                        ->where('budget_id', $budget->id)
                        ->get();

        $month = date('m', strtotime($budget->periode));
        $bulan = "";
        switch ($month) {
            case 1:
                $bulan = "Januari";
                break;
            case 2:
                $bulan = "Februari";
                break;
            case 3:
                $bulan = "Maret";
                break;
            case 4:
                $bulan = "April";
                break;
            case 5:
                $bulan = "Mei";
                break;
            case 6:
                $bulan = "Juni";
                break;
            case 7:
                $bulan = "Juli";
                break;
            case 8:
                $bulan = "Agustus";
                break;
            case 9:
                $bulan = "September";
                break;
            case 10:
                $bulan = "Oktober";
                break;
            case 11:
                $bulan = "November";
                break;
            case 12:
                $bulan = "Desember";
                break;
        }

        return view('admin.budget.export-excel', [
            'budget' => $budget,
            'budgetUsages' => $budgetUsages,
            'bulan' => $bulan,
        ]);
    }
}
