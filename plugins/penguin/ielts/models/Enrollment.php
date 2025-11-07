<?php namespace Penguin\Ielts\Models;

use Model;
use RainLab\User\Models\User;

class Enrollment extends Model
{
    protected $table = 'penguin_ielts_enrollments';
    public $rules = [
        'user_id' => 'required',
        'course_id' => 'required',
        'payment_status' => 'required',
    ];
    protected $fillable = ['user_id', 'course_id', 'payment_status', 'transaction_code', 'paid_at'];

    public $belongsTo = [
        'user' => [User::class],
        'course' => [Course::class],
    ];
}
