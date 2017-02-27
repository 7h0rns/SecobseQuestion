<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
			$table->string('answer_name');
			$table->longText('answer_content');
			$table->longText('html_content');
			$table->integer('question_id')->unsigned()->index();
			$table->string('avatar')->default('default.jpg');
			$table->integer('votes_count')->default(0);
            $table->integer('comments_count')->default(0);
			$table->boolean('isadopt')->default(0);
            $table->timestamps();

			$table->foreign('question_id')
				->references('id')
				->on('questions')
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
        Schema::dropIfExists('answers');
    }
}
