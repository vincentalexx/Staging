<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IzinRequest\IzinRequest;
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

        $izin = Izin::create($data);

        return redirect('thankyou');
    }

    public function thankyou()
    {
        return view('admin.auth.thankyou2');
    }
}
