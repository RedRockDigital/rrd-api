<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('subscription_plans', static function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');
            $table->string('static');
            $table->double('price');
            $table->integer('quantity')->nullable();

            $table->string('product_id')->nullable();
            $table->string('price_id')->nullable();

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
        Schema::dropIfExists('subscription_plans');
    }
};