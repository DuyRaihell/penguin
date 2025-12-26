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
}
