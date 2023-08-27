<?php

namespace App\Http\Requests\Admin\BudgetUsage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreBudgetUsage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.budget-usage.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'tanggal' => ['required', 'date'],
            'jenis_budget' => ['required'],
            'deskripsi' => ['required', 'string'],
            'jumlah_orang' => ['required', 'integer'],
            'total' => ['required', 'numeric'],
            'reimburs' => ['required', 'numeric'],
        ];
    }

    /**
    * Modify input data
    *
    * @return array
    */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
