<?php

namespace App\Console\Commands;

use App\Services\ExpirePendingOrdersService;
use Illuminate\Console\Command;

class ExpirePendingOrdersCommand extends Command
{
    protected $signature = 'orders:expire-pending';

    protected $description = 'Cancel overdue pending QRIS orders and restore menu stock';

    public function handle(ExpirePendingOrdersService $service): int
    {
        $count = $service->expireOverdueOrders();

        $this->info("Expired {$count} pending order(s).");

        return self::SUCCESS;
    }
}
