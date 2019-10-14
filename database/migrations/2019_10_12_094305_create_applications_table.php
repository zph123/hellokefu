<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hello_applications', function (Blueprint $table) {
            $table->string('app_uuid')->unique()->comment('应用编号 系统生成');
            $table->string('welcome_message')->comment('欢迎消息');
            $table->string('end_message')->comment('结束消息');
            $table->increments('id');
            $table->index('app_uuid');
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
        Schema::dropIfExists('hello_applications');
    }
}
