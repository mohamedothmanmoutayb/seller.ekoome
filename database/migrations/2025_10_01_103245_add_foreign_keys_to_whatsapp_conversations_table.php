<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWhatsappConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('whatsapp_conversations', function (Blueprint $table) {
            $table->foreign(['whatsapp_business_account_id'])->references(['id'])->on('whatsapp_business_accounts')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('whatsapp_conversations', function (Blueprint $table) {
            $table->dropForeign('whatsapp_conversations_whatsapp_business_account_id_foreign');
        });
    }
}
