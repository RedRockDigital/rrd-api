<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('action_events', static function (Blueprint $table) {
            $table->id();
            $table->char('batch_id', 36);
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->string('name');
            $table->uuidMorphs('actionable');
            $table->uuidMorphs('target');
            $table->string('model_type');

            $table->uuid('model_id')->nullable();

            $table->text('fields');
            $table->string('status', 25)->default('running');
            $table->text('exception');
            $table->timestamps();

            $table->index(['batch_id', 'model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('action_events');
    }
}
