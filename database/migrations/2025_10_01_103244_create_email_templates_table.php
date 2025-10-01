<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject');
            $table->text('content');
            $table->string('title');
            $table->string('logo')->nullable();
            $table->string('user_id');
            $table->enum('status', ['item packed', 'shipped', 'in transit', 'in delivery', 'incident', 'rejected'])->nullable();
            $table->tinyInteger('active')->default(0);
            $table->integer('id_country')->nullable();
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
        Schema::dropIfExists('email_templates');
    }
}
