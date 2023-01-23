<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('teams', static function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('owner_id')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->string('name');
            $table->text('billing_information')->nullable();
            $table->string('tier')->nullable();
            $table->boolean('has_onboarded')->default(false);
            $table->boolean('payment_failed')->default(false);
            $table->json('features')->nullable();
            $table->json('allowances')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
