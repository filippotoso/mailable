# Configurable Mailable

A Laravel configurable Mailable class that also works with queues.

## Requirements

- PHP 7.2.5+
- Laravel 7+

## Installing

Use Composer to install it:

```
composer require filippo-toso/mailable
```
## What it does?

It allows you to send emails using different mailer settings (ie. SMTPs) depending on external factors. 
This class is very useful when you have a multitenant Laravel application and want to use a different SMTP accounts for each of your tenant.  

## How does it work?

It's easy, just 2 simple steps!

First, extends your mail classes from `FilippoToso\Mailable\Mailable` instead of `Illuminate\Mail\Mailable`:

```php
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use FilippoToso\Mailable\Mailable;

class CustomerPurchase extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }
}

```

Then when you create the mail instance, call the `configure()` method passing your custom mail configuration.
The supported parameters are exactly the same you would put in the `mail.mailers` configuration (in the `config/mail.php` file). 

```php
$mail = (new CustomerPurchase)->configure([
    'transport' => 'smtp',
    'host' => 'smtp.mailgun.org',
    'port' => 587,
    'encryption' => 'tls',
    'username' => 'username',
    'password' => 'password',
    'timeout' => null,
    'auth_mode' => null,
]);

Mail::to('filippo@toso.dev')->queue($mail);
```

You can also do this:

```php
$mail = new CustomerPurchase();

$mail->configure([
    'transport' => 'smtp',
    'host' => 'smtp.mailgun.org',
    'port' => 587,
    'encryption' => 'tls',
    'username' => 'username',
    'password' => 'password',
    'timeout' => null,
    'auth_mode' => null,
]);

Mail::to('filippo@toso.dev')->queue($mail);
```

That's it! 

If you don't call the `configure()` method, this `Mailable` class will behave exactly as the Laravel one ;) 

## Don't want to extend your classes?

If you don't want to (or can't) extend your Mailable classes, just use the `FilippoToso\Mailable\Traits\MailableTrait` trait as follow:

```php
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable;
use FilippoToso\Mailable\Traits\MailableTrait;

class CustomerPurchase extends Mailable
{
    use Queueable, SerializesModels, MailableTrait;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }
}

```

The outcome is the same ;)
