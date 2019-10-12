<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hello_chats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('visitor_id',128)->unique()->nullable(false)->comment('访客编号');
            $table->integer('user_id',false,true)->nullable(false)->comment('客服');
            $table->string('content',255)->comment('内容');
            $table->timestamp('received_at')->nullable()->comment('已读时间');
            $table->index('visitor_id');
            $table->index('user_id');
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
        Schema::dropIfExists('hello_chats');
    }
}
