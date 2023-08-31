<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BudgetExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Budget\BulkDestroyBudget;
use App\Http\Requests\Admin\Budget\DestroyBudget;
use App\Http\Requests\Admin\Budget\IndexBudget;
use App\Http\Requests\Admin\Budget\StoreBudget;
use App\Http\Requests\Admin\Budget\UpdateBudget;
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
use Maatwebsite\Excel\Facades\Excel;
use Spatie\MediaLibrary\Support\MediaStream;

class BudgetsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexBudget $request
     * @return array|Factory|View
     */
    public function index(IndexBudget $request)
    {
        $search = $request->search;
        $orderBy = $request->get('orderBy', 'created_at');
        $orderDirection = $request->get('orderDirection', 'desc');

        if($orderBy == 'id' && $orderDirection == 'asc') {
            $orderBy = 'created_at';
            $orderDirection = 'desc';
        }

        $data = Budget::with([]);
        if(!empty($search)) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('nama_periode', 'LIKE', '%' . $search . '%')
                    ->orWhere('divisi', 'LIKE', '%' . $search . '%');
            });
        }

        $data = $data->orderBy($orderBy, $orderDirection)->paginate($request->get('per_page', 10));

        if ($request->ajax()) {
            return ['data' => $data];
        }

        return view('admin.budget.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.budget.create');

        return view('admin.budget.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBudget $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreBudget $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['periode'] = $sanitized['periode'] . "-01";
        $sanitized['total_budget_terpakai'] = 0;
        $sanitized['total_reimburs'] = 0;
        $sanitized['sisa'] = 0;
        $sanitized['kelebihan'] = 0;
        $sanitized['created_by'] = Auth::user()->id;

        // Store the Budget
        $budget = Budget::create($sanitized);

        $total_budget = 0;
        foreach ($request->budget_details as $budgetDetail) {
            $total = $budgetDetail['jumlah_orang_maksimum'] * $budgetDetail['budget'];

            $budget_detail = BudgetDetail::create([
                'budget_id' => $budget->id,
                'nama_budget' => $budgetDetail['nama_budget'],
                'jumlah_orang_maksimum' => $budgetDetail['jumlah_orang_maksimum'],
                'budget' => $budgetDetail['budget'],
                'total' => $total,
                'is_used' => false,
            ]);

            $total_budget += $total;
        }

        $budgetUpdate = Budget::find($budget->id);
        $budgetUpdate->update([
            'total_budget_awal' => $total_budget,
            'sisa' => $total_budget,
        ]);

        if ($request->ajax()) {
            return ['redirect' => url('admin/budgets'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/budgets');
    }

    /**
     * Display the specified resource.
     *
     * @param Budget $budget
     * @throws AuthorizationException
     * @return void
     */
    public function show(Budget $budget)
    {
        $this->authorize('admin.budget.show', $budget);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Budget $budget
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Budget $budget)
    {
        $this->authorize('admin.budget.edit', $budget);

        $budget = Budget::with(['budgetDetails'])->find($budget->id);

        return view('admin.budget.edit', [
            'budget' => $budget,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBudget $request
     * @param Budget $budget
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateBudget $request, Budget $budget)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['updated_by'] = Auth::user()->id;

        $total_budget = 0;
        foreach ($request->budget_details as $budgetDetail) {
            $total = $budgetDetail['jumlah_orang_maksimum'] * $budgetDetail['budget'];

            if ($budgetDetail['id'] == null) {
                $budget_detail = BudgetDetail::create([
                    'budget_id' => $budget->id,
                    'nama_budget' => $budgetDetail['nama_budget'],
                    'jumlah_orang_maksimum' => $budgetDetail['jumlah_orang_maksimum'],
                    'budget' => $budgetDetail['budget'],
                    'total' => $total,
                    'is_used' => false,
                ]);
            } else {
                $budget_detail = BudgetDetail::find($budgetDetail['id']);
                $budget_detail->update([
                    'nama_budget' => $budgetDetail['nama_budget'],
                    'jumlah_orang_maksimum' => $budgetDetail['jumlah_orang_maksimum'],
                    'budget' => $budgetDetail['budget'],
                    'total' => $total,
                ]);
            }

            $total_budget += $total;
        }

        if ($request->removed_budget_details != null) {
            foreach ($request->removed_budget_details as $removed) {
                $budget_detail = BudgetDetail::find($removed['id']);
                $budget_detail->delete();
            }
        }

        // Update changed values Budget
        $sanitized['total_budget_awal'] = $total_budget;
        $budget->update($sanitized);


        if ($request->ajax()) {
            return [
                'redirect' => url('admin/budgets'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/budgets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyBudget $request
     * @param Budget $budget
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyBudget $request, Budget $budget)
    {
        $budget->budgetDetails()->delete();
        $budget->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyBudget $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyBudget $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Budget::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function duplicate(Request $request, Budget $budget) {
        $newBudget = $budget->replicate();
        $newBudget->nama_periode = $budget->nama_periode . " - Copy";
        $newBudget->created_at = Carbon::now();
        $newBudget->updated_at = null;
        $newBudget->total_budget_terpakai = 0;
        $newBudget->total_reimburs = 0;
        $newBudget->sisa = $budget->total_budget_awal;
        $newBudget->kelebihan = 0;
        $newBudget->save();

        $budgetDetails = BudgetDetail::where('budget_id', $budget->id)->get();
        foreach ($budgetDetails as $budgetDetail) {
            $newBudgetDetail = $budgetDetail->replicate();
            $newBudgetDetail->created_at = Carbon::now();
            $newBudgetDetail->updated_at = null;
            $newBudgetDetail->budget_id = $newBudget->id;
            $newBudgetDetail->is_used = false;
            $newBudgetDetail->save();
        }

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }
    
    public function exportExcel($id)
    {
        $budget = Budget::find($id);
        $month = date('m', strtotime($budget->periode));
        $bulan = "";
        switch ($month) {
            case 1:
                $bulan = "Januari";
                break;
            case 2:
                $bulan = "Februari";
                break;
            case 3:
                $bulan = "Maret";
                break;
            case 4:
                $bulan = "April";
                break;
            case 5:
                $bulan = "Mei";
                break;
            case 6:
                $bulan = "Juni";
                break;
            case 7:
                $bulan = "Juli";
                break;
            case 8:
                $bulan = "Agustus";
                break;
            case 9:
                $bulan = "September";
                break;
            case 10:
                $bulan = "Oktober";
                break;
            case 11:
                $bulan = "November";
                break;
            case 12:
                $bulan = "Desember";
                break;
        }
        $tahun = date('Y', strtotime($budget->periode));

        return Excel::download(new BudgetExport($id), 'FORM KEUANGAN BULANAN ' . $budget->divisi . ' ' . $bulan . ' ' . $tahun . '.xlsx');
    }
    
    public function downloadBonZip($id) {
        $budget = Budget::find($id);
        $budgetUsages = BudgetUsage::where('budget_id', $budget->id)->get();

        $downloads = [];
        foreach($budgetUsages as $budgetUsage) {
            $bonData = $budgetUsage->getMedia('bon_transaksi');

            foreach ($bonData as $bon) {
                $downloads[] = $bon;
            }
        }

        $month = date('m', strtotime($budget->periode));
        $bulan = "";
        switch ($month) {
            case 1:
                $bulan = "Januari";
                break;
            case 2:
                $bulan = "Februari";
                break;
            case 3:
                $bulan = "Maret";
                break;
            case 4:
                $bulan = "April";
                break;
            case 5:
                $bulan = "Mei";
                break;
            case 6:
                $bulan = "Juni";
                break;
            case 7:
                $bulan = "Juli";
                break;
            case 8:
                $bulan = "Agustus";
                break;
            case 9:
                $bulan = "September";
                break;
            case 10:
                $bulan = "Oktober";
                break;
            case 11:
                $bulan = "November";
                break;
            case 12:
                $bulan = "Desember";
                break;
        }
        $tahun = date('Y', strtotime($budget->periode));

        return MediaStream::create('BON TRANSAKSI BULANAN ' . $budget->divisi . ' ' . $bulan . ' ' . $tahun . '.zip')->addMedia($downloads);
    }
}
