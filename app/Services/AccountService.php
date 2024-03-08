<?php

namespace App\Services;

use App\Enums\TransactionStatusEnum;
use App\Exceptions\WithoutBalanceException;
use App\Http\Requests\AccountRequest;
use App\Repositories\AccountRepository;
use App\Repositories\ReceiverRepository;
use App\Repositories\SenderRepository;

class AccountService
{
    protected AccountRepository $accountRepository;
    protected SenderRepository $senderRepository;
    protected ReceiverRepository $receiverRepository;

    public function __construct(AccountRepository $accountRepository, SenderRepository $senderRepository, ReceiverRepository $receiverRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->senderRepository = $senderRepository;
        $this->receiverRepository = $receiverRepository;
    }

    public function create(AccountRequest $request)
    {
        $data = $request->all();
        $data['balance'] = 0.00;
        $this->accountRepository->create($data);
    }

    public function transaction(array $request)
    {
        $response = ExternalService::authorizer($request);

        if (!$response) {
            throw new AuthorizationException('Sem autorização para acessar external');;
        }

        $hasBalance = $this->senderRepository->checkBalance($request['value'], $request['sender']);

        if (!$hasBalance) {
            throw new WithoutBalanceException('Sem saldo para realizar transação!');
        }

        if (!isset($request['date'])) {
            $request['date'] = date('Y-m-d');
        }

        $isScheduled = $this->accountRepository->isScheduled($request['date']);


        if ($isScheduled) {
            $this->accountRepository->transaction($request['sender'], $request['receiver'], $request['value'], $request['date'], TransactionStatusEnum::PENDING);
            return;
        }

        $this->senderRepository->debit($request['value'], $request['sender']);
        $this->receiverRepository->credit($request['value'], $request['receiver']);
        $this->accountRepository->transaction($request['sender'], $request['receiver'], $request['value'], $request['date'], TransactionStatusEnum::APPROVED);
    }
}
