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
            $table->id();
            $table->string('id_manager')->nullable();
            $table->text('code')->nullable();
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->string('email')->unique();
            $table->string('telephone')->nullable();
            $table->string('bank')->nullable();
            $table->string('rib')->nullable();
            $table->string('id_role')->nullable();
            $table->string('id_agentrole')->nullable();
            $table->string('warehouse_id')->nullable();
            $table->string('percentage')->nullable();
            $table->string('is_active')->default(1);
            $table->string('is_deleted')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('last_login')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
