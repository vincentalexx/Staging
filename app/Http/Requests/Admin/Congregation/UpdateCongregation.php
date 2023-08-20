<?php

namespace App\Http\Requests\Admin\Congregation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateCongregation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.congregation.edit', $this->congregation);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id_card' => ['sometimes'],
            'nama_lengkap' => ['sometimes', 'string'],
            'sekolah' => ['sometimes', 'string'],
            'jenis_kelamin' => ['sometimes', 'string'],
            'angkatan' => ['sometimes', 'string'],
            'tgl_lahir' => ['sometimes', 'date'],
            'alamat' => ['sometimes', 'string'],
            'no_wa' => ['sometimes', 'string'],
            'hobi' => ['sometimes', 'string'],
            'status' => ['sometimes', 'string'],
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
