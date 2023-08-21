<?php

namespace App\Exports;

use App\Exports\Sheets\AbsensiJemaatSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AbsensiJemaatExport implements WithMultipleSheets
{
    use Exportable;

    protected $year;
    protected $month;
    protected $bulan;
    
    public function __construct($year, $month, $bulan)
    {
        $this->year = $year;
        $this->month = $month;
        $this->bulan = $bulan;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new AbsensiJemaatSheet($this->year, $this->month, $this->bulan, 'SMP');
        $sheets[] = new AbsensiJemaatSheet($this->year, $this->month, $this->bulan, 'SMA');

        return $sheets;
    }
}
