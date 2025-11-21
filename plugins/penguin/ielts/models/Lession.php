<?php namespace Penguin\Ielts\Models;

use Model;

class Lession extends Model
{
    protected $table = 'penguin_ielts_lessions';

    protected $fillable = ['course_id', 'title', 'description', 'document'];

    /**
     * Relations
     */
    public $belongsTo = [
        'course' => [Course::class]
    ];

    public $rules = [
        'title' => 'required',
        'document' => 'required'
    ];
}
