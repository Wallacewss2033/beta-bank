<?php

namespace App\Repositories;

use App\Enums\TransactionStatusEnum;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AccountRepository extends BaseRepository
{
    protected Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function transaction(string $senderId, string $receiverId, float $value, string $date, TransactionStatusEnum $status): void
    {
        $receiver = $this->find($receiverId);
        $receiver->senderTransactions()->attach($senderId, ['value' => $value, 'date' => $date, 'status' => $status]);
    }

    public function factory(): Factory
    {
        return  $this->account->factory();
    }

    public function isScheduled($value)
    {
        if (strtotime($value) > strtotime(date('Y-m-d')))
            return true;

        return false;
    }
}
