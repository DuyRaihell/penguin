<?php namespace Penguin\Ielts\Models;

use Model;

class AttemptAnswer extends Model
{
    public $table = 'penguin_ielts_attempt_answers';
    public $timestamps = false;

    public $belongsTo = [
        'attempt'  => Attempt::class,
        'question' => Questions::class,
        'answer'   => Answer::class,
    ];
}
