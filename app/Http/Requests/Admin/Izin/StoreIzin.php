<?php

namespace App\Http\Requests\Admin\Izin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreIzin extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.izin.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string'],
            'congregation_id' => ['required', 'string'],
            'angkatan' => ['required', 'string'],
            'kegiatan' => ['required', 'string'],
            'tgl_kegiatan' => ['required', 'date'],
            'keterangan' => ['required', 'string'],
            'alasan' => ['required', 'string'],
            
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
