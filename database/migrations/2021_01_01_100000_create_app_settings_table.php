<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The database schema.
     *
     * @var \Illuminate\Database\Schema\Builder
     */
    protected $schema;

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
     * Get the migration connection name.
     *
     * @return string|null
     */
    public function getConnection()
    {
        return config('vocolab.storage.database.connection');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voco_config_defaults', function (Blueprint $table) {
            $table->id();
            $table->string('config_key')->unique();
            $table->text('default_value')->nullable();
            $table->boolean('inheritable')->unsigned();
            $table->timestamps();
        });

        Schema::create('voco_config_users', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('config_id')->constrained('voco_config_defaults');
            $table->text('value')->nullable();
            $table->timestamps();

            $table->primary(['user_id', 'config_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voco_config_users');
        Schema::dropIfExists('voco_config_defaults');
    }
}
