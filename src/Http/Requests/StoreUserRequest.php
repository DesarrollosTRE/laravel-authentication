<?php namespace Speelpenning\Authentication\Http\Requests;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * @var Guard
     */
    protected $auth;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * StoreUserRequest constructor.
     *
     * @param Guard $auth
     * @param Repository $config
     */
    public function __construct(Guard $auth, Repository $config)
    {
        $this->auth = $auth;
        $this->config = $config;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->guest();
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
            'email'     => ['required', 'email'],
            'password'  => ['required', 'confirmed', 'string', 'min:' . $this->config->get('authentication.password.minLength')],
        ];
    }

    /**
     * Returns the user name rules.
     *
     * @return array
     */
    protected function getUserNameRules()
    {
        return $this->config->get('authentication.registration.userName') == 'required'
            ? ['required', 'string']
            : ['sometimes', 'string'];
    }

}
