<?php namespace Penguin\Ielts\Models;

use Model;

class Attempt extends Model
{
    public $table = 'penguin_ielts_attempts';
    public $timestamps = false;

    protected $fillable = [
        'test_id',
        'user_id',
        'session_id',
        'score',
        'total',
        'started_at',
        'submitted_at',
        'created_at',
    ];
    
    protected $dates = [
        'started_at',
        'submitted_at',
        'created_at',
    ];

    public $belongsTo = [
        'test' => Test::class,
        'user' => \RainLab\User\Models\User::class,
    ];

    public $hasMany = [
        'answers' => AttemptAnswer::class,
    ];

    public function beforeSave()
    {
        $posted = post('answers');
        if (!is_array($posted)) {
            return;
        }

        foreach ($posted as $id => $fields) {
            if (!isset($fields['comment'])) {
                continue;
            }

            $attemptAnswer = AttemptAnswer::find($id);
            if (!$attemptAnswer) {
                continue;
            }

            // if this attempt already exists, ensure the answer belongs to it
            if ($this->id && isset($attemptAnswer->attempt_id) && $attemptAnswer->attempt_id != $this->id) {
                continue;
            }

            $attemptAnswer->comment = $fields['comment'];
            $attemptAnswer->save();
        }
    }
}
