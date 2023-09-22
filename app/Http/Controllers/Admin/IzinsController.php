<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Izin\BulkDestroyIzin;
use App\Http\Requests\Admin\Izin\DestroyIzin;
use App\Http\Requests\Admin\Izin\IndexIzin;
use App\Http\Requests\Admin\Izin\StoreIzin;
use App\Http\Requests\Admin\Izin\UpdateIzin;
use App\Models\Izin;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IzinsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexIzin $request
     * @return array|Factory|View
     */
    public function index(IndexIzin $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Izin::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'nama', 'congregation_id', 'angkatan', 'kegiatan', 'tgl_kegiatan', 'keterangan', 'alasan'],

            // set columns to searchIn
            ['id', 'nama', 'angkatan', 'kegiatan', 'keterangan', 'alasan']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.izin.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.izin.create');

        return view('admin.izin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreIzin $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreIzin $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Izin
        $izin = Izin::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/izins'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/izins');
    }

    /**
     * Display the specified resource.
     *
     * @param Izin $izin
     * @throws AuthorizationException
     * @return void
     */
    public function show(Izin $izin)
    {
        $this->authorize('admin.izin.show', $izin);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Izin $izin
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Izin $izin)
    {
        $this->authorize('admin.izin.edit', $izin);


        return view('admin.izin.edit', [
            'izin' => $izin,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateIzin $request
     * @param Izin $izin
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateIzin $request, Izin $izin)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Izin
        $izin->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/izins'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/izins');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyIzin $request
     * @param Izin $izin
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyIzin $request, Izin $izin)
    {
        $izin->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyIzin $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyIzin $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('izins')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
