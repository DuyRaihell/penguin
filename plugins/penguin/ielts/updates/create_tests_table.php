<?php namespace Penguin\Ielts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTestsTable extends Migration
{
    public function up()
    {
        Schema::create('penguin_ielts_tests', function ($table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penguin_ielts_tests');
    }
}
