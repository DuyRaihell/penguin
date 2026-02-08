<?php namespace Penguin\Ielts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddSlugToTestsTable extends Migration
{
    public function up()
    {
        Schema::table('penguin_ielts_tests', function ($table) {
            $table->string('slug')->nullable()->unique();
        });
    }

    public function down()
    {
        Schema::table('penguin_ielts_tests', function ($table) {
            $table->dropColumn('slug');
        });
    }
}
