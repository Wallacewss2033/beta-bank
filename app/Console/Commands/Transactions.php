<?php

namespace App\Console\Commands;

use App\Enums\TransactionStatusEnum;
use App\Models\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\ReceiverRepository;
use App\Repositories\SenderRepository;
use App\Services\ExternalService;
use Illuminate\Console\Command;

class Transactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'este comando envia as transações agendadas';

    /**
     * Execute the console command.
     */

    public function handle(Transaction $transaction, SenderRepository $sender, ReceiverRepository $receiver)
    {
        $transactions = $transaction->getTransactions(date('Y-m-d'), TransactionStatusEnum::PENDING)->toArray();

        collect($transactions)->map(function ($attribute) use ($transaction, $sender, $receiver) {
            $response = ExternalService::authorizer($attribute);
            if (!$response) {
                $transaction->find($attribute['id'])->update([
                    'status' => TransactionStatusEnum::CANCELED
                ]);
                return;
            }

            $hasBalance = $sender->checkBalance($attribute['value'], $attribute['sender']);

            if (!$hasBalance) {
                $transaction->find($attribute['id'])->update([
                    'status' => TransactionStatusEnum::CANCELED
                ]);
                return;
            }
            $sender->debit($attribute['value'], $attribute['sender']);
            $receiver->credit($attribute['value'], $attribute['receiver']);
            $transaction->find($attribute['id'])->update([
                'status' => TransactionStatusEnum::APPROVED
            ]);
        });
    }
}
