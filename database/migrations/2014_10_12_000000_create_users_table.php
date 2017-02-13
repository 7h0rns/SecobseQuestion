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
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('confirmation_token');
            $table->smallInteger('is_confirm')->default(0);
			$table->string('avatar')->default('default.jpg');
			$table->integer('questions_count')->default(0);
			$table->integer(('answers_count'))->default(0);
			$table->integer('comments_count')->default(0);
			$table->integer('followers_count')->default(0);
			$table->integer('followings_count')->default(0);
            $table->boolean('isadmin')->default(0);
            $table->boolean('isactive')->default(1);
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
