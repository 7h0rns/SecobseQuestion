<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->longText('content');
            $table->integer('user_id')->unsigned();
            $table->string('username');
            $table->integer('recommend_count')->default(0);
            $table->integer('read_count')->unsigned()->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('followers_count')->default(1);
            $table->timestamps();

            $table->foreign('username')
                ->references('name')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
