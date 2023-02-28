<?php

namespace RedRockDigital\Api\Console\Commands;

use Illuminate\Console\Command;
use RedRockDigital\Api\Models\SubscriptionPlan;
use Stripe\Stripe;
use Stripe\StripeClient;

final class StripeSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rrd:stripe-setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up Stripe for the first time';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting to Index Stripe Products');

        // Set the Stripe API key
        $client = new StripeClient(config('cashier.secret'));

        try {
            // Get all products
            collect($client->products->all())
                ->each(function ($product) use ($client) {
                    // Get the price for the product
                    $price = $client->prices->retrieve($product->default_price);

                    $this->info("{$product->name} - {$price->unit_amount}");

                    // Create or update the subscription plan
                    SubscriptionPlan::updateOrCreate([
                        'name'              => $product->name,
                        'stripe_product_id' => $product->id,
                        'price'             => $price->unit_amount / 100,
                        'stripe_price_id'   => $price->id,
                    ]);
                });
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return Command::SUCCESS;
    }
}
