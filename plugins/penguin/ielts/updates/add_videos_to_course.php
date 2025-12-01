<?php namespace Penguin\Ielts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddVideosToCourse extends Migration
{
    public function up()
    {
        Schema::table('penguin_ielts_courses', function($table) {
            $table->json('videos')->nullable()->after('max_in_class');
        });
    }

    public function down()
    {
        Schema::table('penguin_ielts_courses', function($table) {
            $table->dropColumn('videos');
        });
    }
}