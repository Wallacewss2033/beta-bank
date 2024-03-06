<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository extends BaseRepository
{
    protected Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function transaction(string $senderId, string $receiverId, float $value, int $status): void
    {
        $receiver = $this->find($receiverId);
        $receiver->senderTransactions()->attach($senderId, ['value' => $value, 'status' => $status]);
    }
}
