<?php namespace Penguin\Ielts\Models;

use Model;

class Questions extends Model
{
    public $table = 'penguin_ielts_questions';

    public $belongsToMany = [
        'test' => [
            Test::class,
            'table'    => 'penguin_ielts_test_question',
            'key'      => 'question_id',
            'otherKey' => 'test_id',
        ],
    ];

    public $hasMany = [
        'answers' => Answer::class
    ];

    public function checkAnswer($value)
    {
        $correct = $this->answers()->where('is_correct', true)->value('answer');
        return trim($value) === trim($correct);
    }

    public function getAnswerTypeOptions()
    {
        return [
            'choice' => 'Multiple Choice',
            'text'   => 'Text Input',
            'file'   => 'File Upload',
        ];
    }
}
