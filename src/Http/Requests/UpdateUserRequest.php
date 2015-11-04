<?php

namespace Speelpenning\Authentication\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => $this->getUserNameRules(),
            'email'     => ['required', 'email', 'unique:users,email,' . auth()->user()->getAuthIdentifier()],
        ];
    }

    /**
     * Returns the user name rules.
     *
     * @return array
     */
    protected function getUserNameRules()
    {
        return config('authentication.registration.userName') == 'required'
            ? ['required', 'string']
            : ['sometimes', 'string'];
    }
}
