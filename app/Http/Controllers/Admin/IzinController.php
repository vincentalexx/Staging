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
        $keterangan = $request->keterangan;
        $alasan = $request->alasan;
        $tanggal = $request->tgl_kegiatan;
        
        $data = Congregation::with([]);
        $congregationId = $data->where('nama_lengkap', 'LIKE', '%' . $nama . '%')->pluck('id')->first();

        $data = $request->validate([
            'nama' => ['required', 'string'],
            'angkatan' => ['required', 'string'],
            'kegiatan' => ['required', 'string'],
            'tgl_kegiatan' => ['required', 'date'],
            'keterangan' => ['required', 'string'],
            'alasan' => ['required', 'string'],
        ]);

        $data['congregation_id'] = $congregationId;

        $izin = Izin::create($data);

        if($kegiatan == 'Kebaktian'){   
            $congregationAttendance = CongregationAttendance::where('congregation_id', $congregationId)
            ->where('tanggal', $tanggal)
            ->first();
            
            if ($congregationAttendance != null) {
                $congregationAttendance->delete();
            }
            
            $congregationAttendance = CongregationAttendance::create([
                'congregation_id' => $congregationId,
                'tanggal' => $tanggal,
                'keterangan' => $request->keterangan,
            ]);
            return redirect('IzinKegiatan/thankyou');
        }
        
    }

    public function thankyou()
    {
        return view('admin.auth.thankyou2');
    }

    
}