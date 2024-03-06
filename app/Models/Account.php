<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;


class Account extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'balance',
    ];

    protected static function booted()
    {
        static::creating(fn (Account $account) => $account->id = (string) Uuid::uuid4());
    }

    public function senderTransactions()
    {
        return $this->belongsToMany(Account::class, 'transaction', 'receiver', 'sender')
            ->using(Transaction::class)
            ->withPivot('value', 'date', 'isScheduled', 'status');
    }

    public function receiverTransactions()
    {
        return $this->belongsToMany(Account::class, 'transaction', 'sender', 'receiver')
            ->using(Transaction::class)
            ->withPivot('value', 'date', 'isScheduled', 'status');
    }
}
