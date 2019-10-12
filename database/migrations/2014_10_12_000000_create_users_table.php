<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hello_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',60)->comment('姓名');
            $table->string('email',60)->unique()->comment('邮箱');
            $table->string('mobile',30)->unique()->comment('手机号');
            $table->string('avatar')->comment('头像');
            $table->string('password')->comment('密码');
            $table->tinyInteger('role',false,false)->comment('角色 1:超管 0:普通客服');
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::drop('hello_users');
    }
}
