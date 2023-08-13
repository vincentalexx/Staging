<?php

namespace App\Http\Requests\Admin\SignUp;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class SignUp extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
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
            'nama_lengkap' => ['required', 'string'],
            'jenis_kelamin' => ['required', 'string'],
            'kelas' => ['required', 'string'],
            'tgl_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string'],
            'no_wa' => ['required', 'string'],
            'hobi' => ['required', 'string'],
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
