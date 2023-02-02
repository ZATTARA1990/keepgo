<?php

declare(strict_types=1);

namespace App\Handlers;

use App\ValueObjects\Sms;

class CreateAccountMessageHandler
{
    public function __invoke(Sms $sms): void
    {
        // TODO implement sending sms
    }
}
