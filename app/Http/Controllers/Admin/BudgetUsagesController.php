<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BudgetUsage\BulkDestroyBudgetUsage;
use App\Http\Requests\Admin\BudgetUsage\DestroyBudgetUsage;
use App\Http\Requests\Admin\BudgetUsage\IndexBudgetUsage;
use App\Http\Requests\Admin\BudgetUsage\StoreBudgetUsage;
use App\Http\Requests\Admin\BudgetUsage\UpdateBudgetUsage;
use App\Models\Budget;
use App\Models\BudgetDetail;
use App\Models\BudgetUsage;
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

class BudgetUsagesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexBudgetUsage $request
     * @return array|Factory|View
     */
    public function index(IndexBudgetUsage $request, $divisi)
    {
        $search = $request->search;
        $orderBy = $request->get('orderBy', 'created_at');
        $orderDirection = $request->get('orderDirection', 'desc');

        if($orderBy == 'id' && $orderDirection == 'asc') {
            $orderBy = 'created_at';
            $orderDirection = 'desc';
        }

        $data = BudgetUsage::with([])->where('divisi', $divisi);
        if(!empty($search)) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('jenis_budget', 'LIKE', '%' . $search . '%')
                    ->orWhere('deskripsi', 'LIKE', '%' . $search . '%');
            });
        }

        $data = $data->orderBy($orderBy, $orderDirection)->paginate($request->get('per_page', 10));

        if ($request->ajax()) {
            return ['data' => $data];
        }

        return view('admin.budget-usage.index', [
            'data' => $data,
            'divisi' => $divisi,
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
        $this->authorize('admin.budget-usage.create');

        $budgetUsage = new BudgetUsage();

        return view('admin.budget-usage.create', [
            'budgetUsage' => $budgetUsage,
            'divisi' => $divisi,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBudgetUsage $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreBudgetUsage $request, $divisi)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['created_by'] = Auth::user()->id;
        $sanitized['divisi'] = $divisi;
        $sanitized['budget_id'] = $request->jenis_budget['budget_id'];
        $sanitized['budget_detail_id'] = $request->jenis_budget['id'];
        $sanitized['jenis_budget'] = $request->jenis_budget['nama_budget'];

        // Store the BudgetUsage
        $budgetUsage = BudgetUsage::create($sanitized);

        $budgetDetail = BudgetDetail::find($request->jenis_budget['id']);
        $budgetDetail->update([
            'is_used' => true,
        ]);

        if ($request->ajax()) {
            return ['redirect' => url('admin/budget-usages'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/budget-usages/'.$divisi);
    }

    /**
     * Display the specified resource.
     *
     * @param BudgetUsage $budgetUsage
     * @throws AuthorizationException
     * @return void
     */
    public function show(BudgetUsage $budgetUsage)
    {
        $this->authorize('admin.budget-usage.show', $budgetUsage);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BudgetUsage $budgetUsage
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(BudgetUsage $budgetUsage, $divisi)
    {
        $this->authorize('admin.budget-usage.edit', $budgetUsage);

        return view('admin.budget-usage.edit', [
            'budgetUsage' => $budgetUsage,
            'divisi' => $divisi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBudgetUsage $request
     * @param BudgetUsage $budgetUsage
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateBudgetUsage $request, BudgetUsage $budgetUsage, $divisi)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['updated_by'] = Auth::user()->id;
        $sanitized['divisi'] = $divisi;
        $sanitized['budget_id'] = $request->jenis_budget['budget_id'];
        $sanitized['budget_detail_id'] = $request->jenis_budget['id'];

        // Update changed values BudgetUsage
        $budgetUsage->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/budget-usages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/budget-usages/'.$divisi);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyBudgetUsage $request
     * @param BudgetUsage $budgetUsage
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyBudgetUsage $request, BudgetUsage $budgetUsage)
    {
        $budgetUsage->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyBudgetUsage $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyBudgetUsage $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DB::table('budgetUsages')->whereIn('id', $bulkChunk)
                        ->update([
                            'deleted_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
    
    public function getBudgetDetailByTanggal(Request $request) {
        $year = date('Y', strtotime($request->tanggal));
        $month = date('m', strtotime($request->tanggal));

        $budget = Budget::whereYear('periode', $year)
                    ->whereMonth('periode', $month)
                    ->first();

        $budgetDetail = BudgetDetail::where('budget_id', $budget->id)->get();

        return response()->json([
            'budget_detail' => $budgetDetail
        ], 200);
    }
}
