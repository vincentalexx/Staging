<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Congregation;
use App\Http\Requests\Admin\SignUp\SignUp;
use Illuminate\Http\Request;

class SignUpController extends Controller
{
    public function index(Request $request)
    {
        $congregation = new Congregation();

        return view('admin.auth.register', [
            'congregation' => $congregation
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SignUp $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(SignUp $request)
    {
        // dd("asd");
        // Sanitize input
        $sanitized = $request->getSanitized();
        // dd($sanitized);

        // Store the Participant
        $congregation = Congregation::create($sanitized);

        // if ($request->ajax()) {
        //     return ['redirect' => url('thankyou'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        // }

        return redirect('thankyou');
    }

    public function thankyou()
    {
        return view('admin.auth.thankyou');
    }
}
