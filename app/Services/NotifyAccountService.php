<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Account;
use App\Models\SimCard;
use App\ValueObjects\Sms;
use Illuminate\Events\Dispatcher;
use Psr\Log\LoggerInterface;

class NotifyAccountService
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private Dispatcher $dispatcher,
    ) {

    }

    public function notifyAccount(Account $account): void
    {
        $message = $account->name;

        $activeSimCards = $account->simCards->where('is_active', true);

        if ($activeSimCards->count() === 0) {
            $this->logger->info(sprintf('Account %d doesn`t have active sim cards', $account->id));
        }

        foreach ($activeSimCards as $activeSimCard) {
            $this->sendAsyncSms($activeSimCard, $message);
            $this->logger->info(
                sprintf(
                    'Message was sent to queue %s on card %s',
                    $account->id, $activeSimCard->id
                )
            );
        }
    }

    private function sendAsyncSms(SimCard $simCard, string $message): void
    {
        $this->dispatcher->dispatch(new Sms($simCard, $message));
    }
}
