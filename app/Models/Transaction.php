<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Transaction extends Pivot
{
    protected $fillable = [
        'sender',
        'receiver',
        'date',
        'isScheduled',
        'value',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function senderAccount()
    {
        return $this->belongsTo(Account::class, 'sender');
    }

    public function receiverAccount()
    {
        return $this->belongsTo(Account::class, 'receiver');
    }
}
