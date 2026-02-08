<?php namespace Penguin\Ielts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAttemptsTable extends Migration
{
    public function up()
    {
        Schema::create('penguin_ielts_attempts', function ($table) {
            $table->id();
            $table->unsignedBigInteger('test_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id')->nullable();
            $table->integer('score')->default(0);
            $table->integer('total')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('penguin_ielts_attempt_answers', function ($table) {
            $table->id();
            $table->unsignedBigInteger('attempt_id');
            $table->unsignedBigInteger('question_id');
            $table->text('answer_text')->nullable();
            $table->unsignedBigInteger('answer_id')->nullable();
            $table->string('answer_file')->nullable();
            $table->boolean('is_correct')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('penguin_ielts_attempts');
        Schema::dropIfExists('penguin_ielts_attempt_answers');
    }
}
