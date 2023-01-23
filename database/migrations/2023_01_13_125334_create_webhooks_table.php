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

            $table->string('originator');
            $table->string('hook');
            $table->json('payload');
            $table->json('response')->nullable();
            $table->string('status')->default('queued');
            $table->text('idem_key');

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
