<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cs_customer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid', 64)->comment('客户ID');
            $table->string('name', 64)->comment('客户名称');
            $table->string('avatar', 255)->comment('客户头像');
            $table->tinyInteger('client_unread_count', 3)->comment('服务端发送给客户的未读消息数量');
            $table->tinyInteger('server_unread_count', 3)->comment('客户发送给服务端的未读消息数量');
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
        Schema::dropIfExists('cs_customer');
    }
}
