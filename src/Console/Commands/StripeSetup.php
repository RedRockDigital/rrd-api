<?php

namespace RedRockDigital\Api\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use RedRockDigital\Api\Models\SubscriptionPlan;
use Stripe\Stripe;
use Stripe\StripeClient;

/**
 * Class StripeSetup
 *
 * @package RedRockDigital\Api\Console\Commands
 */
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
        // TODO: Convert to off-load to a job, dependinfg on the provider.

        $this->info('Starting to Index Stripe Products');

        // Set the Stripe API key
        $client = new StripeClient(config('cashier.secret'));

        try {
            // Fetch all the products
            collect($client->products->all())->each(function ($product) use ($client) {
                // Get the price for the product
                $price = $client->prices->retrieve($product->default_price);

                // Create or update the subscription plan
                SubscriptionPlan::updateOrCreate([
                    'name'       => $product->name,
                    'static'     => Str::upper($product->name),
                    'product_id' => $product->id,
                    'price'      => $price->unit_amount / 100,
                    'price_id'   => $price->id,
                ]);
            });
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $this->info('Finished Indexing Stripe Products');

        return Command::SUCCESS;
    }
}
