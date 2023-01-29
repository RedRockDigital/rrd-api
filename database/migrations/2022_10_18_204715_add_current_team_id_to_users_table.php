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
        Schema::table('users', static function (Blueprint $table) {
            $table->after('id', function (Blueprint $table) {
                $table->foreignUuid('current_team_id')
                    ->nullable()
                    ->references('id')
                    ->on('teams')
                    ->onDelete('cascade');
            });
        });
    }
};
