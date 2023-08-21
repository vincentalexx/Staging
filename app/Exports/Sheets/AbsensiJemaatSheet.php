<?php

namespace App\Exports\Sheets;

use App\Models\Congregation;
use App\Models\CongregationAttendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;

class AbsensiJemaatSheet implements FromView, WithTitle
{
    private $year;
    private $month;
    private $bulan;
    private $tempat_kebaktian;
    
    public function __construct($year, $month, $bulan, $tempat_kebaktian)
    {
        $this->year = $year;
        $this->month = $month;
        $this->bulan = $bulan;
        $this->tempat_kebaktian = $tempat_kebaktian;
    }

    public function view(): View
    {
        $congregations = Congregation::orderBy('nama_lengkap', 'asc')
                            ->get();
        
        foreach ($congregations as $congregation) {
            $attendances[] = CongregationAttendance::where('tempat_kebaktian', $this->tempat_kebaktian)
                                ->whereCongregationId($congregation->id)
                                ->whereYear('tanggal', $this->year)
                                ->whereMonth('tanggal', $this->month)
                                ->get();
        }

        $selectedMonth = strtotime($this->year . '-' . $this->month . '-01');

        $daysInPeriod = [];
        $dateOfMonth = date('t', $selectedMonth);
        $totalHadir = [];
        for ($i = 1; $i <= $dateOfMonth; $i++) {
            if (date('w', strtotime($this->year . '-' . $this->month . '-' . $i)) == 0) {
                $daysInPeriod[] = $this->year . '-' . $this->month . '-' . $i;
                $totalHadir[strtotime($this->year . '-' . $this->month . '-' . $i)] = 0;
            }
        }

        $calendarData = [];
        foreach ($congregations as $c => $congregation) {
            $calendarData[$c] = [];
            foreach ($daysInPeriod as $d => $day) {
                $calendarData[$c][$d] = [];
                foreach ($attendances[$c] as $attendance) {
                    if (strtotime($attendance->tanggal) == strtotime($day)) {
                        $calendarData[$c][$d] = $attendance;

                        if ($attendance->keterangan == null) {
                            $totalHadir[strtotime($day)] += 1;
                        }
                    } else {
                        if (empty($calendarData[$c][$d])) {
                            $calendarData[$c][$d] = [];
                        }
                    }
                }
            }
        }
        
        return view('admin.congregation-attendance.export-excel', [
            'congregations' => $congregations,
            'calendarData' => $calendarData,
            'totalHadir' => $totalHadir,
            'daysInPeriod' => $daysInPeriod,
            'title' => 'Absensi Jemaat ' . $this->tempat_kebaktian . ' Bulan '. $this->bulan . ' ' . $this->year,
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->tempat_kebaktian;
    }
}
