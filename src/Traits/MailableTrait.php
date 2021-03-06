<?php

namespace FilippoToso\Mailable\Traits;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

trait MailableTrait
{
    protected $mailerConfiguration = null;

    /**
     * Send the message using the given mailer.
     *
     * @param  \Illuminate\Contracts\Mail\Factory|\Illuminate\Contracts\Mail\Mailer  $mailer
     * @return void
     */
    public function send($mailer)
    {
        // If no configuration provided reverto to default behavior
        if (empty($this->mailerConfiguration)) {
            return parent::send($mailer);
        }

        // Create a "virtual" configuration setting in the mail.mailers configurationa array
        $mailerId = (string)Str::uuid();
        $configDot = 'mail.mailers.' . $mailerId;
        config([$configDot => $this->mailerConfiguration]);

        // Create the mailer using the "virtual" configuration setting
        $mailer = Mail::mailer($mailerId);

        // Send the mail using the new mailer 
        $result = parent::send($mailer);

        // Remove the "virtual" configuration setting
        config([$configDot => null]);

        return $result;
    }

    /**
     * Setup the mailer configuration
     *
     * @param array $configuration
     * @return void
     */
    public function configure(array $configuration)
    {
        $this->mailerConfiguration = $configuration;

        return $this;
    }
}
