<?php

namespace Tests\Feature\app\Repositories;

use App\Enums\TransactionStatusEnum;
use App\Models\Account;
use App\Repositories\AccountRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountRepositoryTest extends TestCase
{
    public function test_repository_of_account(): void
    {
        $accountRepository = new AccountRepository(new Account());

        $accountSender = $accountRepository->create([
            'name' => 'Wallace Souza',
            'balance' => 100.50,
        ]);

        $accountReceiver = $accountRepository->create([
            'name' => 'Rejane Pereira',
            'balance' => 100.50,
        ]);

        $accountRepository->transaction($accountSender->id, $accountReceiver->id, 60.50, '2024-03-08', TransactionStatusEnum::APPROVED);

        $this->assertDatabaseHas('accounts', [
            'name' => $accountSender->name,
            'balance' => $accountSender->balance,
        ]);

        $this->assertDatabaseHas('accounts', [
            'name' => $accountReceiver->name,
            'balance' => $accountReceiver->balance,
        ]);

        $this->assertDatabaseHas('transaction', [
            'sender' => $accountSender->id,
            'receiver' => $accountReceiver->id,
            'value' => 60.50,
        ]);
    }
}
