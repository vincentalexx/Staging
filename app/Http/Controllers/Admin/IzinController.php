<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IzinRequest\IzinRequest;
use App\Models\Congregation;
use App\Models\CongregationAttendance;
use App\Models\CongregationDiscipleshipDetail;
use App\Models\DiscipleshipDetail;
use App\Models\Izin;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    public function index(Request $request)
    {
        $izin = new Izin();

        return view('admin.auth.izin', [
            'izin' => $izin
        ]);
    }

    public function store(Request $request)
    {
        $kegiatan = $request->kegiatan;
        $nama = $request->nama;
        $angkatan = $request->angkatan;
        $month = $request->month == null ? date('m') : $request->month;
        $year = $request->year == null ? date('Y') : $request->year;
        $alasan = $request->alasan;
        $tanggal = $request->tgl_kegiatan;

        $data = $request->validate([
            'nama' => ['required', 'string'],
            'angkatan' => ['required', 'string'],
            'kegiatan' => ['required', 'string'],
            'tgl_kegiatan' => ['required', 'date'],
            'alasan' => ['required', 'string'],
        ]);

        $izin = Izin::create($data);

        if($kegiatan == 'Kebaktian'){   
            $congregationId= Congregation::where(function ($x) use ($nama) {
                $x->where('nama_lengkap', 'LIKE', '%' . $nama . '%')->get('congregation_id');
            });
    
            $attendance[] = CongregationAttendance::whereCongregationId($congregationId)
                ->whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->get();
    
            $congregationAttendance = CongregationAttendance::where('congregation_id', $congregationId)
                                        ->where('tanggal', $tanggal)
                                        ->first();
    
            if ($congregationAttendance != null) {
                $congregationAttendance->update([
                    'keterangan' => $alasan,
                ]);
            }
        }
        
        return redirect('IzinKegiatan/thankyou');
    }

    public function thankyou()
    {
        return view('admin.auth.thankyou2');
    }

    
}