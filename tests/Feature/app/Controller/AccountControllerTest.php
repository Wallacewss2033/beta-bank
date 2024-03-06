<?php

namespace Tests\Feature\app\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    public function test_account_create(): void
    {
        $attributes = [
            'name' => 'Ronaldinho Gaúcho',
        ];

        $response = $this->post('/api/accounts', $attributes);

        $response->assertStatus(200);
        $this->assertDatabaseHas('accounts', [
            'name' => $attributes['name'],
            'balance' => 0.00,
        ]);
    }
}
