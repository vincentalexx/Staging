<?php

namespace App\Exports;

use App\Models\Congregation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PendataanJemaatExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $data = Congregation::orderBy('created_at', 'desc')->get();

        return view('admin.congregation.export-excel', [
            'data' => $data,
        ]);
    }
}
