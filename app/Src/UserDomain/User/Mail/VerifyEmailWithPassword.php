<?php

namespace App\Src\UserDomain\User\Mail;

use App\Src\UserDomain\User\Model\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;

class VerifyEmailWithPassword extends Notification
{
    /**
     * The callback that should be used to create the verify email URL.
     *
     * @var \Closure|null
     */
    public static $createUrlCallback;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    private User $user;

    private string $plainPassword;

    public function __construct(User $user, string $plainPassword)
    {

        $this->user = $user;
        $this->plainPassword = $plainPassword;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return $this->buildMailMessage($verificationUrl);
    }

    /**
     * Get the verify email notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {

        return (new MailMessage)
            ->subject(Lang::get('Activate account in LinguaMeeting'))
            ->line('Dear '.$this->user->name)
            ->line('Welcome to LinguaMeeting.')
            ->line('')
            ->line('A LinguaMeeting account has been created for you.')
            ->line(Lang::get('Please click the button below to activate your LinguaMeeting account.'))
            ->action(Lang::get('Verify Linguameeting Email Address'), $url)
            ->line('')
            ->line('User account: '.$this->user->email)
            ->line('Password: '.$this->plainPassword)
            ->line('It is recommended to change the password the first time you enter the application. Your access data are:')
            ->line(new HtmlString("If you wish to contact us, please do not reply to this message but instead contact support: <a href='mailto:support@linguameeting.com'>support@linguameeting.com</a>"));
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable);
        }

        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    /**
     * Set a callback that should be used when creating the email verification URL.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function createUrlUsing($callback)
    {
        static::$createUrlCallback = $callback;
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
