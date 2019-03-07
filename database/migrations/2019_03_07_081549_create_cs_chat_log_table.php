<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsChatLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cs_chat_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('from_id', 64)->comment('发送人ID');
            $table->string('from_name', 64)->comment('发送人用户名');
            $table->string('from_avatar', 255)->comment('发送人头像');
            $table->string('to_id', 64)->comment('接收人ID');
            $table->string('to_name', 64)->comment('接收人用户名');
            $table->string('content', 255)->comment('发送的内容');
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
        Schema::dropIfExists('cs_chat_log');
    }
}
