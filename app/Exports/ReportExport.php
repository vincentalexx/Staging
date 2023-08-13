<?php

namespace App\Exports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $data = Participant::orderBy('created_at', 'desc')->get();
        
        foreach ($data as $d) {
            $bukti_transfer = $d->getMedia('bukti_transfer');
            if (count($bukti_transfer) > 0) {
                $d['bukti_transfer'] = $bukti_transfer[0]->getUrl();
            } else {
                $d['bukti_transfer'] = '';
            }
        }

        return view('admin.participant.export-excel', [
            'data' => $data,
        ]);
    }
}
