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
            $table->boolean('isdouble')->nullable()->default(false);
            $table->string('id_sheet', 250)->nullable();
            $table->text('index_sheet')->nullable();
            $table->string('id_order', 250)->nullable();
            $table->integer('id_last_mille')->nullable();
            $table->string('numEnvio')->nullable();
            $table->longText('tracking')->nullable();
            $table->longText('tracking_return')->nullable();
            $table->string('totalappseal')->nullable()->default('0');
            $table->string('n_lead')->nullable()->unique('n_lead');
            $table->string('id_user')->nullable();
            $table->string('client_id', 250)->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('title')->nullable();
            $table->longText('note')->nullable();
            $table->string('id_country')->nullable();
            $table->string('warehouse_id', 225)->nullable();
            $table->string('id_city')->nullable();
            $table->string('id_zone')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->text('address')->nullable();
            $table->string('zipcod')->nullable();
            $table->string('recipient_number')->nullable();
            $table->text('phone')->nullable();
            $table->text('phone2')->nullable();
            $table->string('id_product', 250)->nullable();
            $table->integer('quantity')->nullable()->default(1);
            $table->text('lead_value')->nullable();
            $table->unsignedTinyInteger('discount')->nullable();
            $table->float('commission', 10, 0)->nullable();
            $table->string('weight', 225)->default('1');
            $table->string('market')->nullable();
            $table->string('status_confirmation')->nullable()->default('new order');
            $table->string('status_livrison')->nullable()->default('unpacked');
            $table->string('status_suivi')->nullable();
            $table->string('status_payment')->nullable()->default('no paid');
            $table->boolean('status')->default(false);
            $table->enum('type', ['seller', 'affiliate'])->nullable()->default('seller');
            $table->string('id_assigned')->nullable();
            $table->string('id_source')->default('facebook');
            $table->dateTime('last_contact')->nullable()->useCurrent();
            $table->dateTime('last_status_change')->nullable()->useCurrent();
            $table->date('last_status_delivery')->nullable();
            $table->tinyInteger('isrollback')->nullable()->default(0);
            $table->string('date_converted')->nullable();
            $table->string('livreur_id')->nullable();
            $table->string('livreur_id_stat', 225)->nullable();
            $table->string('agentwarehouse_id', 250)->nullable();
            $table->string('picker_id', 250)->nullable();
            $table->longText('note_shipping')->nullable();
            $table->string('session')->nullable();
            $table->longText('empty')->nullable();
            $table->dateTime('date_call')->nullable();
            $table->dateTime('date_confirmed')->nullable();
            $table->date('delivered_at')->nullable();
            $table->date('date_picking')->nullable();
            $table->dateTime('date_delivred')->nullable();
            $table->dateTime('date_shipped')->nullable();
            $table->boolean('ispaidapp')->default(false);
            $table->string('method_payment', 225)->nullable()->default('COD');
            $table->string('note_payment', 250)->nullable();
            $table->tinyInteger('prccess_status')->default(0);
            $table->string('fees_confirmation', 225)->nullable();
            $table->string('fees_livrison', 225)->nullable();
            $table->boolean('shipping_fees')->nullable()->default(false);
            $table->string('fees_cod', 225)->nullable();
            $table->text('waybille')->nullable();
            $table->string('shipping_company')->nullable();
            $table->string('bulto')->default('1');
            $table->boolean('packed')->default(false);
            $table->string('etiqueta', 225)->nullable();
            $table->longText('base64_decode')->nullable();
            $table->string('currency')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable();
            $table->string('deleted_at')->nullable()->default('0');
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
