<?php namespace Speelpenning\Authentication\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;
use Speelpenning\Authentication\Http\Requests\StoreUserRequest;
use Speelpenning\Authentication\Jobs\SendPasswordResetLink;
use Speelpenning\Contracts\Authentication\Repositories\UserRepository;

class Admin extends Command {

    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:admin
                            {email : The users e-mail address}
                            {--revoke : Revokes the administrator privileges}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grant or revokes administrator privileges.';

    /**
     * Execute the console command.
     *
     * @param UserRepository $users
     * @return mixed
     */
    public function handle(UserRepository $users)
    {
        try {
            $user = $users->findByEmailAddress($this->argument('email'));

            if ($this->option('revoke')) {
                $user->{$user->managesUsersIndicator()} = false;
                $this->info(trans('authentication::user.admin_revoked', ['email' => $user->email]));
            }
            else {
                $user->{$user->managesUsersIndicator()} = true;
                $this->info(trans('authentication::user.admin_granted', ['email' => $user->email]));
            }

            $users->save($user);
        }
        catch (ModelNotFoundException $e) {
            $this->error('User not found.');
        }
    }

}
