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

    /**
     * Store a newly created resource in storage.
     *
     * @param IzinRequest $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(IzinRequest $request)
    {
        // Sanitize input
        // $sanitized = $request->getSanitized();

        // Store
        // $izin = Izin::create($sanitized);

        dd($request);
        // return redirect('thankyou');
    }

    public function thankyou()
    {
        return view('admin.auth.thankyou');
    }
}
