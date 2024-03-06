<?php

namespace App\Repositories;

use App\Enums\TransactionStatusEnum;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountRepository extends BaseRepository
{
    protected Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function transaction(string $senderId, string $receiverId, float $value, TransactionStatusEnum $status): void
    {
        $receiver = $this->find($receiverId);
        $receiver->senderTransactions()->attach($senderId, ['value' => $value, 'status' => $status]);
    }

    public function factory(): Factory
    {
        return  $this->account->factory();
    }
}
