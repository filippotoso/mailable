<?php

namespace FilippoToso\Mailable;

use FilippoToso\Mailable\Traits\MailableTrait;
use Illuminate\Mail\Mailable as BaseMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Mailable extends BaseMailable
{
    use MailableTrait;
}
