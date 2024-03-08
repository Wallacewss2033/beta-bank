<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\TransactionRequest;
use App\Services\AccountService;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    protected AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function store(AccountRequest $request): JsonResponse
    {
        $this->accountService->create($request);

        return response()->json([
            'message' => 'Conta criada com sucesso!'
        ], 200);
    }

    public function transaction(TransactionRequest $request): JsonResponse
    {
        $this->accountService->transaction($request->all());
        return response()->json([
            'message' => 'transação realizada com sucesso!'
        ], 200);
    }
}
