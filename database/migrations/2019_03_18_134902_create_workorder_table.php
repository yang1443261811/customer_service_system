<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkorderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cs_work_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('from_id', 64)->comment('发送人ID');
            $table->string('from_name', 64)->comment('发送人用户名');
            $table->string('from_avatar', 255)->comment('发送人头像');
            $table->string('content', 255)->comment('发送的内容');
            $table->Integer('kf_id')->comment('处理人,客服的ID');
            $table->tinyInteger('content_type')->comment('消息类型 1是文字消息 2是图片消息 3是表情消息');
            $table->tinyInteger('status')->comment('状态 1是新工单 2是处理中 3是处理完成');
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
        Schema::dropIfExists('cs_work_order');
    }
}
