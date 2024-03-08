<?php

namespace App\Repositories;

class ReceiverRepository extends AccountRepository
{

    public function credit(float $value, string|Uuid $senderId): void
    {
        $sender = $this->find($senderId);
        $sender->balance += $value;
        $sender->update();
    }
}
