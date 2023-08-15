<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Congregation;
use App\Models\CongregationAttendance;
use Illuminate\Http\Request;

class CongregationAttendanceController extends Controller
{
    public function index(Request $request) 
    {
        $search = $request->search;
        $month = $request->month;
        $year = $request->year;

        $orderBy = $request->get('orderBy', 'first_name');
        $orderDirection = $request->get('orderDirection', 'asc');
        if ($orderBy == 'id' && $orderDirection == 'asc') {
            $orderBy = 'first_name';
            $orderDirection = 'asc';
        }

        $congregation = Congregation::where(function ($x) use ($search) {
            $x->where('fullname', 'LIKE', '%' . $search . '%');
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
}
