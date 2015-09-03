<?php namespace Speelpenning\Authentication\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Mail\Message;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Speelpenning\Authentication\Events\PasswordResetLinkWasSent;
use Speelpenning\Authentication\Events\PasswordWasChanged;
use Speelpenning\Authentication\PasswordReset;
use Speelpenning\Authentication\Repositories\PasswordResetRepository;
use Speelpenning\Authentication\Repositories\UserRepository;

class SendPasswordResetLink implements SelfHandling {

    /**
     * @var string
     */
    protected $email;

    /**
     * Create a new job instance.
     *
     * @param string $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @param UserRepository $users
     * @param PasswordResetRepository $repository
     * @param Repository $config
     * @param Mailer $mail
     * @param Dispatcher $event
     * @return void
     */
    public function handle(UserRepository $users, PasswordResetRepository $repository, Repository $config, Mailer $mail, Dispatcher $event)
    {
        $repository->cleanUp($this->email);

        $user = $users->findByEmailAddress($this->email);

        $reset = PasswordReset::generate($this->email);

        $repository->save($reset);

        $mail->send(
            $config->get('authentication.passwordReset.email'),
            compact('user', 'reset'),
            function (Message $message) use ($user, $config) {
                $message
                    ->from($config->get('authentication.passwordReset.from.email'), $config->get('authentication.passwordReset.from.name'))
                    ->to($user->email, $user->name)
                    ->subject(trans('authentication::password-reset.subject'));
            }
        );

        $event->fire(new PasswordResetLinkWasSent($reset));
    }
}
