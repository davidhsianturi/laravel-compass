<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompassRouteablesTable extends Migration
{
    /**
     * The database schema.
     *
     * @var Schema
     */
    protected $schema;

    /**
     * Create a new migration instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->schema = Schema::connection(
            config('compass.storage.database.connection')
        );
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('compass_routeables', function (Blueprint $table) {
            $table->uuid('storage_id')->unique();
            $table->string('route_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('network')->nullable(); // params, headers, body, etc.
            $table->timestamps();

            $table->index(['route_id', 'title']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('compass_routeables');
    }
}
