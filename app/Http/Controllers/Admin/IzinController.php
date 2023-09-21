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
        $data = $request->validate([
            'nama' => ['required', 'string'],
            'angkatan' => ['required', 'string'],
            'kegiatan' => ['required', 'string'],
            'tgl_kegiatan' => ['required', 'date'],
            'alasan' => ['required', 'string'],
        ]);
        
        $dataRequest = $request->input('key');
        session()->flash('dataKey', $dataRequest);

        $izin = Izin::create($data);

        return redirect('IzinKegiatan/getPerson');
    }

    public function getPerson(){
        $dataRequest = session()->get('dataKey');
        // $kegiatan = $dataRequest->kegiatan;

        dd($dataRequest);

        // if($kegiatan == 'Kebaktian'){
        //     return $this->kebaktian();
        // }
        // if($kegiatan == 'Pembinaan'){
        //     return $this->pembinaan();
        // }
    }

    public function kebaktian(){
        $dataRequest = session()->get('dataKey');
        $nama = $dataRequest->nama;
        $angkatan = $dataRequest->angkatan;
        $month = $dataRequest->month == null ? date('m') : $dataRequest->month;
        $year = $dataRequest->year == null ? date('Y') : $dataRequest->year;
        $alasan = $dataRequest->alasan;
        $tanggal = $dataRequest->tgl_kegiatan;

        // $orderBy = $request->get('orderBy', 'nama_lengkap');
        // $orderDirection = $request->get('orderDirection', 'asc');
        // if ($orderBy == 'id' && $orderDirection == 'asc') {
        //     $orderBy = 'nama_lengkap';
        //     $orderDirection = 'asc';
        // }

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
                'keterangan' => $dataRequest->keterangan,
            ]);
        }
        return redirect('IzinKegiatan/thankyou');
    }

    // public function kebaktian($congregationId, $tanggal, $id)
    // {
    //     $discipleshipDetail = DiscipleshipDetail::find($id);

    //     $congregationDiscpleshipDetail = CongregationDiscipleshipDetail::where('congregation_id', $congregationId)
    //                                 ->where('discipleship_detail_id', $id)
    //                                 ->first();
        
    //     $congregation = Congregation::find($congregationId);

    //     return redirect('IzinKegiatan/thankyou');
    // }

    public function thankyou()
    {
        return view('admin.auth.thankyou2');
    }

    
}
