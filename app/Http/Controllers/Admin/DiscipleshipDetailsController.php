<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DiscipleshipDetail\BulkDestroyDiscipleshipDetail;
use App\Http\Requests\Admin\DiscipleshipDetail\DestroyDiscipleshipDetail;
use App\Http\Requests\Admin\DiscipleshipDetail\IndexDiscipleshipDetail;
use App\Http\Requests\Admin\DiscipleshipDetail\StoreDiscipleshipDetail;
use App\Http\Requests\Admin\DiscipleshipDetail\UpdateDiscipleshipDetail;
use App\Models\Congregation;
use App\Models\CongregationDiscipleshipDetail;
use App\Models\Discipleship;
use App\Models\DiscipleshipDetail;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DiscipleshipDetailsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexDiscipleshipDetail $request
     * @return array|Factory|View
     */
    public function index(IndexDiscipleshipDetail $request, $divisi)
    {
        $search = $request->search;
        $month = $request->month == null ? date('m') : $request->month;
        $year = $request->year == null ? date('Y') : $request->year;

        $pembinaan = Discipleship::where('divisi', $divisi)->first();

        $discipleship = $request->discipleship == null ? $pembinaan->id : $request->discipleship;

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

        $attendance = [];
        foreach ($congregations as $key => $congregationData) {
            if (!isset($attendance[$key])) {
                $attendance[$key] = [];
            }
            $discipleshipDetails = DiscipleshipDetail::whereDiscipleshipId($discipleship)
                ->whereYear('tanggal', $year)
                ->whereMonth('tanggal', $month)
                ->where('divisi', $divisi)
                ->get();

            foreach ($discipleshipDetails as $discipleshipDetail) {
                $congregationDiscpleshipDetail = CongregationDiscipleshipDetail::with(['discipleshipDetail'])
                                    ->where('discipleship_detail_id', $discipleshipDetail->id)
                                    ->where('congregation_id', $congregationData->id)
                                    ->first();

                if ($congregationDiscpleshipDetail != null) {
                    $attendance[$key][] = $congregationDiscpleshipDetail;
                }

                if (count($attendance[$key]) > 0) {
                    foreach ($attendance[$key] as $a) {
                        if(!isset($a['tanggal'])) {
                            $a['tanggal'] = date('Y-m-d', strtotime($discipleshipDetail->tanggal));
                        }
                    }
                }
            }
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
                        'divisi'              => $divisi,
                    ]
                ]
            ];
        }

        return view('admin.discipleship-detail.index', [
            'data' => [
                'data' => [
                    'data'                => $data,
                    'attendance'          => $attendance,
                    'divisi'              => $divisi,
                ]
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create($divisi)
    {
        $this->authorize('admin.discipleship-detail.create');

        $discipleships = Discipleship::where('divisi', $divisi)->get();

        return view('admin.discipleship-detail.create', [
            'divisi' => $divisi,
            'discipleships' => $discipleships,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDiscipleshipDetail $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreDiscipleshipDetail $request, $divisi)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['created_by'] = Auth::user()->id;
        $sanitized['discipleship_id'] = $request->discipleship['id'];
        $sanitized['divisi'] = $divisi;

        $congregations = collect($request->congregations);
        $congregationIds = $congregations->pluck('id')->all();

        // Store the DiscipleshipDetail
        if (!$request->isTanggalSudahTerisi) {
            $discipleshipDetail = DiscipleshipDetail::create($sanitized);
        } else {
            $discipleshipDetail = DiscipleshipDetail::where('discipleship_id', $sanitized['discipleship_id'])
                                    ->where('tanggal', $sanitized['tanggal'])
                                    ->first();
            $discipleshipDetail->update([
                'updated_by' => Auth::user()->id,
                'judul' => $sanitized['judul'],
            ]);
        }
        $discipleshipDetail->congregation()->attach($congregationIds);

        if ($request->ajax()) {
            return ['redirect' => url('admin/discipleship-details/' . $divisi), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/discipleship-details/' . $divisi);
    }

    /**
     * Display the specified resource.
     *
     * @param DiscipleshipDetail $discipleshipDetail
     * @throws AuthorizationException
     * @return void
     */
    public function show(DiscipleshipDetail $discipleshipDetail)
    {
        $this->authorize('admin.discipleship-detail.show', $discipleshipDetail);

        // TODO your code goes here
    }

    public function editDetail($congregationId, $tanggal, $id) {
        $discipleshipDetail = DiscipleshipDetail::find($id);

        $congregationDiscpleshipDetail = CongregationDiscipleshipDetail::where('congregation_id', $congregationId)
                                    ->where('discipleship_detail_id', $id)
                                    ->first();
        
        $congregation = Congregation::find($congregationId);

        return view('admin.discipleship-detail.edit', [
            'discipleshipDetail' => $discipleshipDetail,
            'congregationDiscpleshipDetail' => $congregationDiscpleshipDetail,
            'tanggal' => $tanggal,
            'congregation' => $congregation,
        ]);
    }
    
    public function update(Request $request, $congregationId, $discipleshipDetailId) 
    {
        $discipleshipDetail = DiscipleshipDetail::find($discipleshipDetailId);
        $congregationDiscipleshipDetail = CongregationDiscipleshipDetail::where('discipleship_detail_id', $discipleshipDetailId)
                                            ->where('congregation_id', $congregationId)
                                            ->first();

        if ($congregationDiscipleshipDetail != null) {
            $congregationDiscipleshipDetail->update([
                'keterangan' => $request->keterangan,
                'alasan' => $request->alasan,
            ]);
        } else {
            $congregationDiscipleshipDetail = CongregationDiscipleshipDetail::create([
                'congregation_id' => $congregationId,
                'discipleship_detail_id' => $discipleshipDetailId,
                'keterangan' => $request->keterangan,
                'alasan' => $request->alasan,
            ]);
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/discipleship-details/' . $discipleshipDetail->divisi),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/discipleship-details/' . $discipleshipDetail->divisi);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DiscipleshipDetail $discipleshipDetail
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(DiscipleshipDetail $discipleshipDetail)
    {
        $this->authorize('admin.discipleship-detail.edit', $discipleshipDetail);

        return view('admin.discipleship-detail.edit', [
            'discipleshipDetail' => $discipleshipDetail,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyDiscipleshipDetail $request
     * @param DiscipleshipDetail $discipleshipDetail
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyDiscipleshipDetail $request, DiscipleshipDetail $discipleshipDetail)
    {
        $discipleshipDetail->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    public function destroyDetail(Request $request, $id)
    {
        $congregationDiscpleshipDetail = CongregationDiscipleshipDetail::find($id);
        $congregationDiscpleshipDetail->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyDiscipleshipDetail $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyDiscipleshipDetail $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('discipleshipDetails')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function getCongregationList(Request $request) {
        $discipleshipDetail = DiscipleshipDetail::where('tanggal', $request->tanggal)
                                ->where('discipleship_id', $request->discipleship)
                                ->first();

        $congregationDiscpleshipDetails = [];
        if ($discipleshipDetail != null) {
            $congregationDiscpleshipDetails = CongregationDiscipleshipDetail::where('discipleship_detail_id', $discipleshipDetail->id)
                                                ->get()
                                                ->pluck('congregation_id');
        }

        $congregations = Congregation::whereNotIn('id', $congregationDiscpleshipDetails)
                            ->orderBy('nama_lengkap', 'asc')
                            ->get(['id', 'nama_lengkap', 'angkatan']);

        return response()->json([
            'congregations' => $congregations,
            'discipleshipDetail' => $discipleshipDetail,
        ]);
    }

    public function getDiscipleshipList(Request $request) {
        $discipleships = Discipleship::where('divisi', $request->divisi)->get();

        return response()->json($discipleships);
    }

    public function getTotalHadir(Request $request) {
        $discipleship = Discipleship::find($request->discipleship);

        $discipleshipDetails = DiscipleshipDetail::whereYear('tanggal', $request->year)
                                ->whereMonth('tanggal', $request->month)
                                ->where('discipleship_id', $request->discipleship)
                                ->get();

        $hari = 0;
        switch ($discipleship->hari) {
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

        $attendances = [];
        $judulPembinaan = [];
        $selectedMonth = strtotime($request->year . '-' . $request->month . '-01');
        $dateOfMonth = date('t', $selectedMonth);
        for ($i = 1; $i <= $dateOfMonth; $i++) {
            if (date('w', strtotime($request->year . '-' . $request->month . '-' . $i)) == $hari) {
                $daysInPeriod[] = $request->year . '-' . $request->month . '-' . $i;
                $attendances[strtotime($request->year . '-' . $request->month . '-' . $i)] = 0;
                $judulPembinaan[strtotime($request->year . '-' . $request->month . '-' . $i)] = '';
            }
        }

        foreach ($discipleshipDetails as $key => $discipleshipDetail) {
            $attendances[strtotime($daysInPeriod[$key])] = CongregationDiscipleshipDetail::with(['discipleshipDetail'])
                                ->where('discipleship_detail_id', $discipleshipDetail->id)
                                ->whereNull('keterangan')
                                ->count();

            $judulPembinaan[strtotime($daysInPeriod[$key])] = $discipleshipDetail;
        }

        return response()->json([
            'totalHadir' => $attendances,
            'judulPembinaan' => $judulPembinaan,
        ]);
    }
}
