<?php namespace Penguin\Ielts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddCorrectAnswerToAttemptAnswers extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('penguin_ielts_attempt_answers', 'correct_answer')) {
            Schema::table('penguin_ielts_attempt_answers', function ($table) {
                $table->text('correct_answer')->nullable();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('penguin_ielts_attempt_answers', 'correct_answer')) {
            Schema::table('penguin_ielts_attempt_answers', function ($table) {
                $table->dropColumn('correct_answer');
            });
        }
    }
}
