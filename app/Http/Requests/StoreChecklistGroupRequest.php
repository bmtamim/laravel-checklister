<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreChecklistGroupRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
        $rule = Rule::unique('checklist_groups');
        if ($this->route()->hasParameter('checklist_group')) {
            $rule = Rule::unique('checklist_groups')->ignoreModel($this->checklist_group);
        }
        return [
            'name' => ['required', $rule],
        ];
    }
}
