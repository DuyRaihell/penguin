<?php namespace Penguin\Ielts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateEnrollmentsTable extends Migration
{
    public function up()
    {
        Schema::create('penguin_ielts_enrollments', function ($table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');
            $table->string('payment_status')->default('pending');
            $table->string('transaction_code')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penguin_ielts_enrollments');
    }
}
