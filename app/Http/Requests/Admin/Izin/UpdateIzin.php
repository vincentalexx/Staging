<?php

namespace App\Http\Requests\Admin\Izin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateIzin extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.izin.edit', $this->izin);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'nama' => ['sometimes', 'string'],
            'congregation_id' => ['sometimes', 'string'],
            'angkatan' => ['sometimes', 'string'],
            'kegiatan' => ['sometimes', 'string'],
            'tgl_kegiatan' => ['sometimes', 'date'],
            'keterangan' => ['sometimes', 'string'],
            'alasan' => ['sometimes', 'string'],
            
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
