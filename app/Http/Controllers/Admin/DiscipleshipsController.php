<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Discipleship\BulkDestroyDiscipleship;
use App\Http\Requests\Admin\Discipleship\DestroyDiscipleship;
use App\Http\Requests\Admin\Discipleship\IndexDiscipleship;
use App\Http\Requests\Admin\Discipleship\StoreDiscipleship;
use App\Http\Requests\Admin\Discipleship\UpdateDiscipleship;
use App\Models\Discipleship;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DiscipleshipsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexDiscipleship $request
     * @return array|Factory|View
     */
    public function index(IndexDiscipleship $request)
    {
        $search = $request->search;
        $orderBy = $request->get('orderBy', 'created_at');
        $orderDirection = $request->get('orderDirection', 'desc');

        if($orderBy == 'id' && $orderDirection == 'asc') {
            $orderBy = 'created_at';
            $orderDirection = 'desc';
        }

        $data = Discipleship::with([]);
        if(!empty($search)) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('nama_pembinaan', 'LIKE', '%' . $search . '%');
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

        return view('admin.discipleship.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.discipleship.create');

        return view('admin.discipleship.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDiscipleship $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreDiscipleship $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['created_by'] = Auth::user()->id;

        // Store the Discipleship
        $discipleship = Discipleship::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/discipleships'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/discipleships');
    }

    /**
     * Display the specified resource.
     *
     * @param Discipleship $discipleship
     * @throws AuthorizationException
     * @return void
     */
    public function show(Discipleship $discipleship)
    {
        $this->authorize('admin.discipleship.show', $discipleship);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Discipleship $discipleship
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Discipleship $discipleship)
    {
        $this->authorize('admin.discipleship.edit', $discipleship);


        return view('admin.discipleship.edit', [
            'discipleship' => $discipleship,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDiscipleship $request
     * @param Discipleship $discipleship
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateDiscipleship $request, Discipleship $discipleship)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['updated_by'] = Auth::user()->id;

        // Update changed values Discipleship
        $discipleship->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/discipleships'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/discipleships');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyDiscipleship $request
     * @param Discipleship $discipleship
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyDiscipleship $request, Discipleship $discipleship)
    {
        $discipleship->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyDiscipleship $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyDiscipleship $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Discipleship::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
