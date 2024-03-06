<?php

namespace App\Repositories;

use App\Models\Account;
use Ramsey\Uuid\Uuid;

class BaseRepository
{
    protected Account $account;

    public function create(array $attributes): Account
    {
        return $this->account->create($attributes);
    }

    public function find(int|string|Uuid $id): Account
    {
        return $this->account->find($id);
    }
}
