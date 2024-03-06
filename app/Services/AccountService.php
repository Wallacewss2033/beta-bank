<?php

namespace App\Services;

use App\Http\Requests\AccountRequest;
use App\Repositories\AccountRepository;

class AccountService
{
    protected AccountRepository $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function create(AccountRequest $request)
    {
        $data = $request->all();
        $data['balance'] = 0.00;
        $this->accountRepository->create($data);
    }
}
