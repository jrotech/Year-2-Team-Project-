<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer;
use Illuminate\Support\Facades\File;

class ExportCustomerCSV extends Command
{
    protected $signature = 'export:customers';
    protected $description = 'Export customers to CSV for Artillery';

    public function handle()
    {
        $customers = Customer::limit(700)->get(['email']);

        $csv = "email,password\n";
        foreach ($customers as $customer) {
            $csv .= "{$customer->email},password\n"; //  used 'password' in the factory
        }

        File::put(base_path('tests/artillery/users.csv'), $csv);
        $this->info('Exported users to tests/artillery/users.csv');
    }
}
