<?php

namespace Speelpenning\Authentication\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;
use Speelpenning\Authentication\Http\Requests\StoreUserRequest;
use Speelpenning\Authentication\Jobs\BanUser;
use Speelpenning\Authentication\Jobs\SendPasswordResetLink;
use Speelpenning\Authentication\Jobs\UnbanUser;
use Speelpenning\Contracts\Authentication\Repositories\UserRepository;

class Ban extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:ban
                            {email : The users e-mail address}
                            {--unban : Unbans the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bans or unbans a user.';

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

            if ($this->option('unban')) {
                $this->dispatch(new UnbanUser($user->id));
                $this->info(trans('authentication::user.unbanned', ['email' => $user->email]));
            } else {
                $this->dispatch(new BanUser($user->id));
                $this->info(trans('authentication::user.banned', ['email' => $user->email]));
            }

            $users->save($user);
        } catch (ModelNotFoundException $e) {
            $this->error('User not found.');
        }
    }
}
