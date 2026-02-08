<?php namespace Penguin\Ielts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddMaxEnrollmentsToCourse extends Migration
{
    public function up()
    {
        Schema::table('penguin_ielts_courses', function($table) {
            $table->unsignedBigInteger('max_in_class')->nullable()->after('slug');
        });
    }

    public function down()
    {
        Schema::table('penguin_ielts_courses', function($table) {
            $table->dropColumn('max_in_class');
        });
    }
}