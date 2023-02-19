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
        Schema::create('webhooks', static function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('provider');
            $table->string('event');
            $table->json('payload');
            $table->json('ouput')->nullable();
            $table->string('status')->default('queued');
            $table->text('key')->unique();

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
        Schema::dropIfExists('webhooks');
    }
};
