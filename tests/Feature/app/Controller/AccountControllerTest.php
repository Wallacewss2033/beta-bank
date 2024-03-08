<?php

namespace Tests\Feature\app\Controller;

use App\Enums\TransactionStatusEnum;
use App\Models\Account;
use App\Repositories\AccountRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    public function test_endpoint_of_account_create(): void
    {
        $attributes = [
            'name' => 'Ronaldinho Gaúcho',
            'balance' => '150.00',
        ];

        $response = $this->post('/api/accounts', $attributes);

        $response->assertStatus(200);
    }

    public function test_endpoints_of_transactions()
    {
        $accountRepository = new AccountRepository(new Account());
        $accountSender = $accountRepository->create([
            'name' => 'Wallace Souza',
            'balance' => '100.50',
        ]);

        $accountReceiver = $accountRepository->create([
            'name' => 'Rejane Pereira',
            'balance' => '100.50',
        ]);


        $attributes = [
            'sender' => $accountSender['id'],
            'receiver' => $accountReceiver['id'],
            'value' => '15.00'
        ];

        $response = $this->post('/api/accounts/transactions', $attributes);

        $response->assertStatus(200);
        $this->assertDatabaseHas('accounts', [
            'id' => $accountSender['id'],
            'name' => $accountSender['name'],
            'balance' => $accountSender['balance'] - $attributes['value']
        ]);
        $this->assertDatabaseHas('accounts', [
            'id' => $accountReceiver['id'],
            'name' => $accountReceiver['name'],
            'balance' => $accountReceiver['balance'] + $attributes['value']
        ]);
        $this->assertDatabaseHas('transaction', [
            'sender' => $accountSender['id'],
            'receiver' => $accountReceiver['id'],
            'value' => 15.00,
            'status' => TransactionStatusEnum::APPROVED,
        ]);
    }

    public function test_endpoints_of_transactions_scheduled()
    {
        $accountRepository = new AccountRepository(new Account());
        $accountSender = $accountRepository->create([
            'name' => 'João Souza',
            'balance' => '100.50',
        ]);

        $accountReceiver = $accountRepository->create([
            'name' => 'Flávia Pereira',
            'balance' => '100.50',
        ]);


        $attributes = [
            'sender' => $accountSender['id'],
            'receiver' => $accountReceiver['id'],
            'value' => "15.00",
            'date' => date('Y-m-d', strtotime("+1 days")),
        ];

        $response = $this->post('/api/accounts/transactions', $attributes);

        $response->assertStatus(200);

        $this->assertDatabaseHas('transaction', [
            'sender' => $accountSender['id'],
            'receiver' => $accountReceiver['id'],
            'value' => 15.00,
            'status' => TransactionStatusEnum::PENDING,
        ]);

        $this->assertDatabaseHas('accounts', [
            'id' => $accountSender['id'],
            'name' => $accountSender['name'],
            'balance' => $accountSender['balance']
        ]);
        $this->assertDatabaseHas('accounts', [
            'id' => $accountReceiver['id'],
            'name' => $accountReceiver['name'],
            'balance' => $accountReceiver['balance']
        ]);
    }

    public function test_endpoints_of_transactions_scheduled_without_balance()
    {
        $accountRepository = new AccountRepository(new Account());
        $accounts = $accountRepository->factory()->count(2)->create()->toArray();
        $attributes = [
            'sender' => $accounts[0]['id'],
            'receiver' => $accounts[1]['id'],
            'value' => "15.00",
            'date' => date('Y-m-d', strtotime("+1 days")),
        ];

        $response = $this->post('/api/accounts/transactions', $attributes);

        $response->assertStatus(422);

        $this->assertTrue($attributes['value'] > $accounts[0]['balance']);
    }
}
