<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Models\SimCard;

class Sms
{
    public function __construct(public SimCard $simCard, public string $message)
    {
    }
}
