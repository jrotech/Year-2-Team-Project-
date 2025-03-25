<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\InvoiceOrder;
use App\Models\Customer;
use App\Models\Product;
use Faker\Factory as Faker;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();
        $customers = Customer::all();
        $products = Product::all();
        
        // Ensure we have customers and products available
        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->info("No customers or products available to seed invoices.");
            return;
        }
        
        // Create 100 invoices
        for ($i = 0; $i < 100; $i++) {
            // Pick a random customer
            $customer = $customers->random();
            
            // Generate a random date within the last 3 months
            $invoiceDate = $faker->dateTimeBetween('-3 months', 'now');
        
            
            // Generate dummy address and postcode
            $address = $faker->address;
            $postcode = strtoupper($faker->bothify('??## ?##'));
            
            // Random status for the invoice
            $statuses = ['pending', 'paid'];
            $status = $faker->randomElement($statuses);
            
          
            
            // Create the invoice; set invoice_amount to 0 initially.
            // We are also faking the created_at and updated_at timestamps using the invoice date.
            $invoice = Invoice::create([
                'customer_id'     => $customer->id,
                'amount'  => 0, // temporary value to be updated later
                'address'         => $address,
                'postcode'        => $postcode,
                'status'          => $status,
                'created_at'      => $invoiceDate,
                'updated_at'      => $invoiceDate,
            ]);
            
            // Create a random number of invoice orders for this invoice (between 1 and 5)
            $numOrders = $faker->numberBetween(1, 5);
            $totalAmount = 0;
            
            for ($j = 0; $j < $numOrders; $j++) {
                // Pick a random product
                $product = $products->random();
                
                // Determine a random quantity between 1 and 3
                $quantity = $faker->numberBetween(1, 3);
                
                // Assume product_cost is the unit price from the Product model
                $productCost = $product->price;
                
                // Compute the total for this order
                $orderAmount = $quantity * $productCost;
                $totalAmount += $orderAmount;
                
                // Generate a random timestamp 
                $orderTimestamp = $invoiceDate;
                
                InvoiceOrder::create([
                    'invoice_id'   => $invoice->invoice_id,
                    'product_id'   => $product->id,
                    'product_cost' => $productCost,
                    'quantity'     => $quantity,
                    'created_at'   => $orderTimestamp,
                    'updated_at'   => $orderTimestamp,
                ]);
            }
            
            // Update the invoice amount with the total calculated from the orders
            $invoice->amount = $totalAmount;
            $invoice->save();
        }
    }
}
