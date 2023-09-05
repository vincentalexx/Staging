<?php

namespace App\Exports\Sheets;

use App\Models\Congregation;
use App\Models\CongregationAttendance;
use App\Models\CongregationDiscipleshipDetail;
use App\Models\DiscipleshipDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;

class AbsensiPembinaanSheet implements FromView, WithTitle
{
    private $year, $month, $bulan, $discipleship;
    
    public function __construct($year, $month, $bulan, $discipleship)
    {
        $this->year = $year;
        $this->month = $month;
        $this->bulan = $bulan;
        $this->discipleship = $discipleship;
    }

    public function view(): View
    {
        $congregations = Congregation::orderBy('nama_lengkap', 'asc')->get();
        
        $attendances = [];
        $congregationIds = [];
        foreach ($congregations as $key => $congregationData) {
            if (!isset($attendances[$key])) {
                $attendances[$key] = [];
            }
            $discipleshipDetails = DiscipleshipDetail::whereDiscipleshipId($this->discipleship->id)
                ->whereYear('tanggal', $this->year)
                ->whereMonth('tanggal', $this->month)
                ->where('divisi', $this->discipleship->divisi)
                ->get();

            foreach ($discipleshipDetails as $discipleshipDetail) {
                $congregationDiscpleshipDetail = CongregationDiscipleshipDetail::with(['discipleshipDetail'])
                                    ->where('discipleship_detail_id', $discipleshipDetail->id)
                                    ->where('congregation_id', $congregationData->id)
                                    ->first();

                if ($congregationDiscpleshipDetail != null) {
                    $attendances[$key][] = $congregationDiscpleshipDetail;
                    $congregationIds[] = $congregationData->id;
                }

                if (count($attendances[$key]) > 0) {
                    foreach ($attendances[$key] as $a) {
                        if(!isset($a['tanggal'])) {
                            $a['tanggal'] = date('Y-m-d', strtotime($discipleshipDetail->tanggal));
                        }
                    }
                }
            }
        }

        $congregations = Congregation::whereIn('id', $congregationIds)->orderBy('nama_lengkap', 'asc')->get();

        $selectedMonth = strtotime($this->year . '-' . $this->month . '-01');

        $hari = 0;
        switch ($this->discipleship->hari) {
            case "Minggu":
                $hari = 0;
                break;
            case "Senin":
                $hari = 1;
                break;
            case "Selasa":
                $hari = 2;
                break;
            case "Rabu":
                $hari = 3;
                break;
            case "Kamis":
                $hari = 4;
                break;
            case "Jumat":
                $hari = 5;
                break;
            case "Sabtu":
                $hari = 6;
                break;
        }

        $daysInPeriod = [];
        $dateOfMonth = date('t', $selectedMonth);
        $totalHadir = [];
        for ($i = 1; $i <= $dateOfMonth; $i++) {
            if (date('w', strtotime($this->year . '-' . $this->month . '-' . $i)) == $hari) {
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
        
        return view('admin.discipleship-detail.export-excel', [
            'congregations' => $congregations,
            'calendarData' => $calendarData,
            'totalHadir' => $totalHadir,
            'daysInPeriod' => $daysInPeriod,
            'discipleshipDetails' => $discipleshipDetails,
            'title' => 'Absensi Pembinaan ' . $this->discipleship->divisi . ' Bulan '. $this->bulan . ' ' . $this->year,
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->discipleship->nama_pembinaan;
    }
}
