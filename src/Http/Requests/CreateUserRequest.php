<?php namespace Speelpenning\Authentication\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guest() and $this->publicRegistrationIsAllowed();
    }

    /**
     * Checks whether public registration is allowed.
     * @return bool
     */
    protected function publicRegistrationIsAllowed()
    {
        return config('authentication.registration.allowPublic') == 'true';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

}
