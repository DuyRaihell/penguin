<?php namespace Penguin\Ielts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('penguin_ielts_questions', function ($table) {
            $table->id();
            $table->foreignId('test_id')->nullable()->constrained('penguin_ielts_tests')->cascadeOnDelete();
            $table->enum('section', ['listening', 'writing', 'speaking', 'grammar']);
            $table->text('question');
            $table->string('audio')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penguin_ielts_questions');
    }
}
