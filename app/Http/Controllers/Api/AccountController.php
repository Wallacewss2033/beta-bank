<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Services\AccountService;

class AccountController extends Controller
{
    protected AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function store(AccountRequest $request)
    {
        $this->accountService->create($request);

        return response()->json([
            'message' => 'Conta criada com sucesso!'
        ], 200);
    }
}
