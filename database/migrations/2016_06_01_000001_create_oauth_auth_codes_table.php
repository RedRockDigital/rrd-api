<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * The database schema.
     *
     * @var Builder
     */
    protected Builder $schema;

    /**
     * Create a new migration instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->schema = Schema::connection($this->getConnection());
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->schema->create('oauth_auth_codes', static function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('client_id');
            $table->text('scopes')->nullable();
            $table->boolean('revoked');
            $table->dateTime('expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->schema->dropIfExists('oauth_auth_codes');
    }

    /**
     * Get the migration connection name.
     *
     * @return string|null
     */
    public function getConnection(): ?string
    {
        return config('passport.storage.database.connection');
    }
};
