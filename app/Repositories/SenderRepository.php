<?php

namespace App\Repositories;

use App\Models\Account;

class SenderRepository extends AccountRepository
{
    public function debit(float $value, string|Uuid $senderId): void
    {
        $sender = $this->find($senderId);
        $sender->balance -= $value;
        $sender->update();
    }

    public function checkBalance(float $value, string|Uuid $sender): bool
    {
        $balance = $this->find($sender)->balance;

        return $balance >= $value ? true : false;
    }
}
