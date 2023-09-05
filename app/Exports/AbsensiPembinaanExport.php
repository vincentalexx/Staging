<?php

namespace App\Exports;

use App\Exports\Sheets\AbsensiPembinaanSheet;
use App\Models\Discipleship;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AbsensiPembinaanExport implements WithMultipleSheets
{
    use Exportable;

    protected $year, $month, $bulan, $divisi;
    
    public function __construct($year, $month, $bulan, $divisi)
    {
        $this->year = $year;
        $this->month = $month;
        $this->bulan = $bulan;
        $this->divisi = $divisi;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $discipleships = Discipleship::where('divisi', $this->divisi)->get();

        foreach ($discipleships as $discipleship) {
            $sheets[] = new AbsensiPembinaanSheet($this->year, $this->month, $this->bulan, $discipleship);
        }

        return $sheets;
    }
}
