<?php namespace Penguin\Ielts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAnswersTable extends Migration
{
    public function up()
    {
        Schema::create('penguin_ielts_answers', function ($table) {
            $table->id();
            $table->foreignId('questions_id')->constrained('penguin_ielts_questions')->cascadeOnDelete();
            $table->string('answer');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penguin_ielts_answers');
    }
}
