<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;

class ExportCustomerCSV extends Command
{
    protected $signature = 'export:customers';
    protected $description = 'Export customers to CSV for Artillery';

    public function handle()
    {
        $customers = Customer::limit(50)->get(['email']);

        $csv = "email,password\n";
        foreach ($customers as $customer) {
            $csv .= "{$customer->email},password\n"; //  used 'password' in the factory
        }

        Storage::disk('local')->put('artillery/users.csv', $csv);
        $this->info('Exported users to storage/app/artillery/users.csv');
    }
}
