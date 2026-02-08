<?php namespace Penguin\Ielts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddAnswerTypeToQuestions extends Migration
{
    public function up()
    {
        Schema::table('penguin_ielts_questions', function ($table) {
            $table->string('answer_type', 50)->default('choice');
        });
    }

    public function down()
    {
        Schema::table('penguin_ielts_questions', function ($table) {
            $table->dropColumn('answer_type');
        });
    }
}
