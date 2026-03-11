<?php namespace Penguin\Ielts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddCommentToAttemptAnswers extends Migration
{
    public function up()
    {
        Schema::table('penguin_ielts_attempt_answers', function ($table) {
            $table->text('comment')->nullable();
        });
    }

    public function down()
    {
        Schema::table('penguin_ielts_attempt_answers', function ($table) {
            $table->dropColumn('comment');
        });
    }
}
