<?php

namespace App\Http\Requests\Admin\BudgetUsage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateBudgetUsage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.budget-usage.edit', $this->budgetUsage);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'tanggal' => ['sometimes', 'date'],
            'jenis_budget' => ['sometimes'],
            'deskripsi' => ['sometimes', 'string'],
            'jumlah_orang' => ['sometimes', 'integer'],
            'total' => ['sometimes', 'numeric'],
            'reimburs' => ['sometimes', 'numeric'],
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
