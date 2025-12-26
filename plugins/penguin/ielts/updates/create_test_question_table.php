<?php namespace Penguin\Ielts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTestQuestionTable extends Migration
{
    public function up()
    {
        Schema::create('penguin_ielts_test_question', function ($table) {
            $table->id();
            $table->unsignedBigInteger('test_id');
            $table->unsignedBigInteger('question_id');
            $table->integer('sort_order')->default(0);

            $table->unique(['test_id', 'question_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('penguin_ielts_test_question');
    }
}
