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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('true_name',60)->comment('真实姓名');
            $table->string('job_num',60)->comment('工号');
            $table->string('email',60)->unique()->comment('邮箱');
            $table->string('phone',30)->unique()->comment('手机号');
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
        Schema::drop('users');
    }
}
