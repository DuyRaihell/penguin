<?php namespace Penguin\Ielts\Models;

use Model;

class AttemptAnswer extends Model
{
    public $table = 'penguin_ielts_attempt_answers';
    public $timestamps = false;

    public $fillable = [
        'comment',
        'attempt_id',
        'question_id',
        'answer_id',
        'answer_text',
        'answer_file',
        'is_correct',
        'correct_answer',
    ];

    public $belongsTo = [
        'attempt'  => Attempt::class,
        'question' => Questions::class,
        'answer'   => Answer::class,
    ];

    public function saveComment($text)
    {
        $this->comment = $text;
        return $this->save();
    }
}
