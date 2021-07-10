<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\NoReturn;

class StoreTaskRequest extends FormRequest
{
    protected $errorBag = 'storetask';

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

    public function rules()
    {

        return [
            'name'        => ['required', 'string',],
            'description' => ['nullable', 'string'],
        ];
    }
}
