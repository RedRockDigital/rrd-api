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
        Schema::create('stripe_subscriptions', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignUuid('team_id');
            $table->string('stripe_id');
            $table->foreignUuid('subscription_plan_id')->constrained()->cascadeOnDelete();

            $table->string('stripe_status');
            $table->integer('quantity')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('next_payment_date')->nullable();
            $table->float('next_payment_amount')->nullable();
            $table->timestamps();

            $table->index(['team_id', 'stripe_status', 'stripe_id']);
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
