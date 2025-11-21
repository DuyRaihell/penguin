<?php namespace Penguin\Ielts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateLessionsTable extends Migration
{
    public function up()
    {
        Schema::create('penguin_ielts_lessions', function($table) {
            $table->increments('id');
            $table->integer('course_id')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('document')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penguin_ielts_lessions');
    }
}
