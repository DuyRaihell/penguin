<?php namespace Penguin\Ielts\Models;

use Model;

class Course extends Model
{
    protected $table = 'penguin_ielts_courses';
    
    public $rules = [
        'title' => 'required',
        'price' => 'required|numeric',
    ];

    protected $fillable = ['title', 'description', 'price', 'slug'];

    public $hasMany = [
        'enrollments' => [Enrollment::class],
    ];
}
