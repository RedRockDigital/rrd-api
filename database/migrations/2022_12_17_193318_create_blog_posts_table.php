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
        Schema::create('blogs', static function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('featured_image')->nullable();
            $table->string('title');
            $table->string('author');
            $table->text('snippet');
            $table->longText('body');
            $table->timestamp('published_at')->nullable();
            $table->integer('estimate_read_time');

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
        Schema::dropIfExists('blogs');
    }
};
