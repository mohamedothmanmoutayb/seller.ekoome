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
            $table->id();
            $table->string('id_country')->nullable();
            $table->string('id_lastmile');
            $table->string('id_user');
            $table->text('auth_id')->nullable();
            $table->text('auth_key');
            $table->timestamps();
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
