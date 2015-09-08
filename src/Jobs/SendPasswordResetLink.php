<?php namespace Speelpenning\Authentication\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Speelpenning\Authentication\Events\PasswordResetLinkWasSent;
use Speelpenning\Authentication\PasswordReset;
use Speelpenning\Contracts\Authentication\Repositories\PasswordResetRepository;
use Speelpenning\Contracts\Authentication\Repositories\UserRepository;

class SendPasswordResetLink implements SelfHandling, ShouldQueue {

    use InteractsWithQueue, SerializesModels;

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
     * @param PasswordResetRepository $resets
     * @param Repository $config
     * @param Mailer $mail
     * @param Dispatcher $event
     * @return void
     */
    public function handle(UserRepository $users, PasswordResetRepository $resets, Repository $config, Mailer $mail, Dispatcher $event)
    {
        $resets->cleanUp($this->email);

        $user = $users->findByEmailAddress($this->email);

        $passwordReset = PasswordReset::generate($user);

        $resets->save($passwordReset);

        $mail->send(
            $config->get('authentication.passwordReset.email'),
            compact('user', 'passwordReset'),
            function (Message $message) use ($user, $config) {
                $message
                    ->from($config->get('authentication.passwordReset.from.email'), $config->get('authentication.passwordReset.from.name'))
                    ->to($user->email, $user->name)
                    ->subject(trans('authentication::password-reset.subject'));
            }
        );

        $event->fire(new PasswordResetLinkWasSent($passwordReset));
    }

}
