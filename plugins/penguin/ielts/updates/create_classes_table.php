<?php namespace Penguin\Ielts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateClassesTable extends Migration
{
    public function up()
    {
        Schema::create('penguin_ielts_classes', function($table) {
            $table->id();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('assistant_id')->nullable();
            $table->string('name')->nullable();
            $table->integer('max_members')->nullable();
            $table->integer('current_members')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penguin_ielts_classes');
    }
}
