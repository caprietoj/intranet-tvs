<?php

namespace App\Console\Commands;

use App\Models\Equipment;
use Illuminate\Console\Command;

class ResetEquipmentInventory extends Command
{
    protected $signature = 'equipment:reset';
    protected $description = 'Reset equipment inventory to initial values';

    public function handle()
    {
        Equipment::resetInventory();
        $this->info('Equipment inventory has been reset successfully.');
    }
}
