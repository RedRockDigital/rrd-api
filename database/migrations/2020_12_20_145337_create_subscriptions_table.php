<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateSubscriptionsTable
 */
return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('subscriptions', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('team_id');
            $table->string('name');
            $table->float('price')->nullable();
            $table->string('stripe_id');
            $table->string('stripe_status');
            $table->string('stripe_price')->nullable();
            $table->string('stripe_plan')->nullable();
            $table->integer('quantity')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('next_payment_date')->nullable();
            $table->timestamps();

            $table->index(['team_id', 'stripe_status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
