<?php

namespace App\Models;

use App\Enums\TransactionStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Transaction extends Pivot
{
    protected $fillable = [
        'sender',
        'receiver',
        'date',
        'value',
        'status'
    ];


    public function senderAccount()
    {
        return $this->belongsTo(Account::class, 'sender');
    }

    public function receiverAccount()
    {
        return $this->belongsTo(Account::class, 'receiver');
    }

    public function getTransactions($date, $status)
    {
        return $this->where(['date' => $date, 'status' => $status])->get();
    }
}
