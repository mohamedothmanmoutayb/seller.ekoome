<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('isdouble')->nullable();
            $table->string('id_sheet')->nullable();
            $table->string('index_sheet')->nullable();
            $table->string('id_order')->nullable();
            $table->string('tracking')->nullable();
            $table->string('totalappseal')->nullable();
            $table->string('n_lead')->nullable();
            $table->string('id_user')->nullable();
            $table->string('client_id')->nullable();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('note')->nullable();
            $table->string('id_country')->nullable();
            $table->string('id_city')->nullable();
            $table->string('id_zone')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();
            $table->string('id_product')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('lead_value')->nullable();
            $table->string('weight')->nullable();
            $table->string('status_confirmation')->nullable();
            $table->string('status_livrison')->nullable();
            $table->string('status_payment')->nullable();
            $table->boolean('status')->default(0);
            $table->string('id_assigned')->default('assigned');
            $table->string('id_source')->default('facebook');
            $table->string('last_contact')->nullable();
            $table->string('last_status_change')->nullable();
            $table->string('last_status_delivery')->nullable();
            $table->string('date_converted')->nullable();
            $table->string('livreur_id')->nullable();
            $table->string('livreur_id_stat')->nullable();
            $table->string('agentwarehouse_id')->nullable();
            $table->string('picker_id')->nullable();
            $table->string('note_shipping')->nullable();
            $table->string('session')->nullable();
            $table->string('empty')->nullable();
            $table->string('date_call')->nullable();
            $table->date('date_confirmed')->nullable();
            $table->date('date_delivred')->nullable();
            $table->date('date_shipped')->nullable();
            $table->boolean('ispaidapp')->nullable();
            $table->string('note_payment')->nullable();
            $table->string('prccess_status')->nullable();
            $table->string('fees_confirmation')->nullable();
            $table->string('fees_livrison')->nullable();
            $table->string('fees_cod')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
