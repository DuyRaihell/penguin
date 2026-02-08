<?php namespace Penguin\Ielts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddClassIdToEnrollments extends Migration
{
    public function up()
    {
        Schema::table('penguin_ielts_enrollments', function($table) {
            $table->unsignedBigInteger('class_id')->nullable()->after('course_id');
        });
    }

    public function down()
    {
        Schema::table('penguin_ielts_enrollments', function($table) {
            $table->dropColumn('class_id');
        });
    }
}
