<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AbsensiJemaatExport;
use App\Http\Controllers\Controller;
use App\Models\Congregation;
use App\Models\CongregationAttendance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CongregationAttendancesController extends Controller
{
    public function index(Request $request) 
    {
        $search = $request->search;
        $month = $request->month == null ? date('m') : $request->month;
        $year = $request->year == null ? date('Y') : $request->year;

        $orderBy = $request->get('orderBy', 'nama_lengkap');
        $orderDirection = $request->get('orderDirection', 'asc');
        if ($orderBy == 'id' && $orderDirection == 'asc') {
            $orderBy = 'nama_lengkap';
            $orderDirection = 'asc';
        }

        $congregation = Congregation::where(function ($x) use ($search) {
            $x->where('nama_lengkap', 'LIKE', '%' . $search . '%');
        });

        $data = $congregation->orderBy($orderBy, $orderDirection)->paginate($request->get('per_page', 10));

        $congregations = $congregation->get();

        foreach ($congregations as $congregationData) {
            $attendance[] = CongregationAttendance::whereCongregationId($congregationData->id)
                ->whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->get();
        }

        if ($request->ajax()) {
            return [
                'data' => [
                    'current_page' => $data->toArray()['current_page'],
                    'last_page'    => $data->toArray()['last_page'],
                    'total'        => $data->toArray()['total'],
                    'per_page'     => $data->toArray()['per_page'],
                    'to'           => $data->toArray()['to'],
                    'from'         => $data->toArray()['from'],
                    'data' => [
                        'data'                => $data,
                        'attendance'          => $attendance,
                    ]
                ]
            ];
        }

        return view('admin.congregation-attendance.index', [
            'data' => [
                'data' => [
                    'data'                => $data,
                    'attendance'          => $attendance,
                ]
            ],
        ]);
    }

    public function edit()
    {
        $congregations = Congregation::with(['congregationAttendance'])
                            ->orderBy('nama_lengkap', 'asc')
                            ->get(['id', 'nama_lengkap', 'angkatan']);

        return view('admin.congregation-attendance.edit', [
            'congregations' => $congregations,
        ]);
    }

    public function update(Request $request) 
    {
        foreach ($request->congregations as $congregation) {
            $jam_datang = '09:59:59';
            if ($request->keterangan != null) {
                $jam_datang = null;
            }

            $congregationAttendance = CongregationAttendance::create([
                'congregation_id' => $congregation['id'],
                'tanggal' => $request['tanggal'],
                'jam_datang' => $jam_datang,
                'keterangan' => $request->keterangan,
                'tempat_kebaktian' => $request->tempat_kebaktian,
            ]);
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/congregation-attendances'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/congregation-attendances');
    }

    public function getCongregationList(Request $request) {
        $congregationAttendances = CongregationAttendance::where('tanggal', $request->tanggal)
                                    ->get()
                                    ->pluck('congregation_id');

        $congregations = Congregation::whereNotIn('id', $congregationAttendances)
                            ->orderBy('nama_lengkap', 'asc')
                            ->get(['id', 'nama_lengkap', 'angkatan']);

        return response()->json($congregations);
    }

    public function getTotalHadir(Request $request) {
        $attendances = CongregationAttendance::whereNull('keterangan')
                                ->whereYear('tanggal', $request->year)
                                ->whereMonth('tanggal', $request->month)
                                ->get(['id', 'tanggal', 'tempat_kebaktian']);

        $selectedMonth = strtotime($request->year . '-' . $request->month . '-01');
        $dateOfMonth = date('t', $selectedMonth);
        $totalHadirSMP = [];
        $totalHadirSMA = [];
        for ($i = 1; $i <= $dateOfMonth; $i++) {
            if (date('w', strtotime($request->year . '-' . $request->month . '-' . $i)) == 0) {
                $daysInPeriod[] = $request->year . '-' . $request->month . '-' . $i;
                $totalHadirSMP[strtotime($request->year . '-' . $request->month . '-' . $i)] = 0;
                $totalHadirSMA[strtotime($request->year . '-' . $request->month . '-' . $i)] = 0;
            }
        }

        foreach ($attendances as $attendance) {
            foreach ($daysInPeriod as $d => $day) {
                if (strtotime($attendance->tanggal) == strtotime($day)) {
                    if ($attendance->keterangan == null && $attendance->tempat_kebaktian == "SMP") {
                        $totalHadirSMP[strtotime($day)] += 1;
                    } else if ($attendance->keterangan == null && $attendance->tempat_kebaktian == "SMA") {
                        $totalHadirSMA[strtotime($day)] += 1;
                    }
                }
            }
        }

        return response()->json([
            'totalHadirSMP' => $totalHadirSMP,
            'totalHadirSMA' => $totalHadirSMA,
        ]);
    }
    
    public function editDetail($congregationId, $tanggal) {
        $congregationAttendance = CongregationAttendance::where('congregation_id', $congregationId)
                                    ->where('tanggal', $tanggal)
                                    ->first();
        
        $congregation = Congregation::find($congregationId);

        return view('admin.congregation-attendance.edit-detail', [
            'congregationAttendance' => $congregationAttendance,
            'tanggal' => $tanggal,
            'congregation' => $congregation,
        ]);
    }
    
    public function updateDetail(Request $request, $congregationId, $tanggal) 
    {
        $jam_datang = $request->jam_datang;
        if ($request->keterangan != null) {
            $jam_datang = null;
        }

        $congregationAttendance = CongregationAttendance::where('congregation_id', $congregationId)
                                    ->where('tanggal', $tanggal)
                                    ->first();

        if ($congregationAttendance != null) {
            $congregationAttendance->update([
                'jam_datang' => $jam_datang,
                'keterangan' => $request->keterangan,
                'tempat_kebaktian' => $request->tempat_kebaktian,
            ]);
        } else {
            $congregationAttendance = CongregationAttendance::create([
                'congregation_id' => $congregationId,
                'tanggal' => $tanggal,
                'jam_datang' => $jam_datang,
                'keterangan' => $request->keterangan,
                'tempat_kebaktian' => $request->tempat_kebaktian,
            ]);
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/congregation-attendances'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/congregation-attendances');
    }

    public function destroyDetail(Request $request, $id)
    {
        $congregationAttendance = CongregationAttendance::find($id);
        $congregationAttendance->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    public function exportExcel(Request $request, $year, $month)
    {
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

        return Excel::download(new AbsensiJemaatExport($year, $month, $bulan), 'Absensi Jemaat Bulan ' . $bulan . ' ' . $year . '.xlsx');
    }


    /**
     * API Card Detection
     */
    public function createCongregationAttendance(Request $request) {
        $congregation = Congregation::whereIdCard($request->id_card)->first();

        $congregationAttendance = CongregationAttendance::create([
            'congregation_id' => $congregation->id,
            'tanggal' => date('Y-m-d'),
            'jam_datang' => date('H:m:s'),
            'tempat_kebaktian' => $request->tempat_kebaktian,
        ]);

        return response()->json([
            'message' => 'Data berhasil dibuat',
            'status' => 201
        ]);
    }
}
