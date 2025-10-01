<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLastmilleIntegrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lastmille_integrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_country')->nullable();
            $table->string('id_lastmile');
            $table->string('id_user');
            $table->string('name', 225)->nullable();
            $table->text('auth_id')->nullable();
            $table->text('auth_key');
            $table->text('api_key')->nullable();
            $table->string('type', 225)->default('simple');
            $table->string('open', 225)->default('yes');
            $table->string('fragile', 225)->default('0');
            $table->string('fees_delivered', 225)->nullable()->default('0');
            $table->string('fees_returned', 225)->nullable()->default('0');
            $table->string('fees_refuse', 225)->default('0');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lastmille_integrations');
    }
}
