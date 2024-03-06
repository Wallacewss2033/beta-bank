<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Repositories\AccountRepository;
use Database\Factories\AccountFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(AccountRepository $accountRepository): void
    {
        $accountRepository->factory()->create();
    }
}
