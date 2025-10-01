<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_manager', 250)->nullable();
            $table->string('departement')->nullable();
            $table->text('code')->nullable();
            $table->string('name');
            $table->string('company', 250)->nullable();
            $table->string('email')->unique();
            $table->string('telephone')->nullable();
            $table->text('bank')->nullable();
            $table->text('rib')->nullable();
            $table->string('id_role')->default('2');
            $table->string('id_agentrole', 225)->nullable();
            $table->string('country_id', 225)->nullable();
            $table->string('warehouse_id')->nullable();
            $table->string('percentage')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->dateTime('last_login')->useCurrent();
            $table->timestamps();
            $table->text('contract')->nullable();
            $table->text('rates')->nullable();
            $table->text('registration')->nullable();
            $table->string('ref')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
