<?php

namespace App\Repositories;

use App\Models\Account;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaseRepository
{
    protected Account $account;

    public function create(array $attributes): Account
    {
        return $this->account->create($attributes);
    }

    public function find(int|string|Uuid $id): Account
    {
        $account = $this->account->find($id);
        if (!$account)
            throw new NotFoundHttpException('conta não identificada.');
        return $account;
    }
}
