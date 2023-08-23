<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PendataanJemaatExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Congregation\BulkDestroyCongregation;
use App\Http\Requests\Admin\Congregation\DestroyCongregation;
use App\Http\Requests\Admin\Congregation\IndexCongregation;
use App\Http\Requests\Admin\Congregation\StoreCongregation;
use App\Http\Requests\Admin\Congregation\UpdateCongregation;
use App\Models\Congregation;
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
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class CongregationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexCongregation $request
     * @return array|Factory|View
     */
    public function index(IndexCongregation $request)
    {
        $search = $request->search;
        $orderBy = $request->get('orderBy', 'created_at');
        $orderDirection = $request->get('orderDirection', 'desc');

        if($orderBy == 'id' && $orderDirection == 'asc') {
            $orderBy = 'created_at';
            $orderDirection = 'desc';
        }

        $data = Congregation::with([]);
        if(!empty($search)) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('id_card', 'LIKE', '%' . $search . '%')
                    ->orWhere('nama_lengkap', 'LIKE', '%' . $search . '%');
            });
        }

        $data = $data->orderBy($orderBy, $orderDirection)->paginate($request->get('per_page', 10));

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.congregation.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.congregation.create');

        return view('admin.congregation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCongregation $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCongregation $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Congregation
        $congregation = Congregation::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/congregations'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/congregations');
    }

    /**
     * Display the specified resource.
     *
     * @param Congregation $congregation
     * @throws AuthorizationException
     * @return void
     */
    public function show(Congregation $congregation)
    {
        $this->authorize('admin.congregation.show', $congregation);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Congregation $congregation
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Congregation $congregation)
    {
        $this->authorize('admin.congregation.edit', $congregation);


        return view('admin.congregation.edit', [
            'congregation' => $congregation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCongregation $request
     * @param Congregation $congregation
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCongregation $request, Congregation $congregation)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Congregation
        $congregation->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/congregations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/congregations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCongregation $request
     * @param Congregation $congregation
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCongregation $request, Congregation $congregation)
    {
        $congregation->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCongregation $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyCongregation $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('congregations')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new PendataanJemaatExport(), 'pendataan-jemaat.xlsx');
    }
}
