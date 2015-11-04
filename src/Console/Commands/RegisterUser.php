<?php

namespace Speelpenning\Authentication\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;
use Speelpenning\Authentication\Http\Requests\StoreUserRequest;
use Speelpenning\Authentication\Jobs\SendPasswordResetLink;

class RegisterUser extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:register
                            {email : The e-mail address used for logging in}
                            {name? : The user\'s (real) name}
                            {--with-reset : E-mail a password reset link to the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registers a new user.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $input = $this->collectInput();

        try {
            $this->validateInput($input);

            $this->registerUser($input);

            $this->sendResetPasswordLink($input);
        } catch (ValidationException $e) {
            $this->error(PHP_EOL . implode(PHP_EOL, $e->errors()->all()) . PHP_EOL);
        }
    }

    /**
     * Returns an array with all required input.
     *
     * @return array
     */
    protected function collectInput()
    {
        $password = $this->generateRandomPassword();

        return [
            'name' => $this->argument('name') ? $this->argument('name') : '',
            'email' => $this->argument('email'),
            'password' => $password,
            'password_confirmation' => $password,
        ];
    }

    /**
     * Generates a random password with the minimum required length.
     *
     * @return string
     */
    protected function generateRandomPassword()
    {
        return Str::random(config('authentication.password.minLength'));
    }

    /**
     * Validates the input.
     *
     * @param array $data
     * @throws ValidationException
     */
    protected function validateInput(array $data)
    {
        $rules = (new StoreUserRequest())->rules();

        $validation = app(Factory::class)->make($data, $rules);

        if ($validation->fails()) {
            throw new ValidationException($validation->getMessageBag());
        }
    }

    /**
     * Performs the user registration.
     *
     * @param array $input
     */
    protected function registerUser(array $input)
    {
        $this->dispatchFromArray(\Speelpenning\Authentication\Jobs\RegisterUser::class, $input);
        $this->info(trans('authentication::user.console.created', $input));
    }

    /**
     * Sends the reset password link (if confirmed).
     *
     * @param array $input
     */
    protected function sendResetPasswordLink(array $input)
    {
        if ($this->option('with-reset')) {
            $this->dispatchFromArray(SendPasswordResetLink::class, $input);
            $this->info(trans('authentication::password-reset.console.created'));
        }
    }
}
