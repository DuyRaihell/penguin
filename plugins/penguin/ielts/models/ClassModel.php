<?php namespace Penguin\Ielts\Models;

use Model;
use Backend\Models\User;

class ClassModel extends Model
{
    protected $table = 'penguin_ielts_classes';
    protected $fillable = ['course_id', 'name', 'max_members', 'current_members', 'assistant_id'];

    public $belongsTo = [
        'course' => [Course::class],
        'assistant' => [
            User::class, 
            'key' => 'assistant_id',
        ],
    ];

    public $hasMany = [
        'enrollments' => [
            Enrollment::class,
            'key'   => 'class_id', // foreign key in enrollments table
            'otherKey' => 'id',
        ],
    ];

    public function isFull(): bool
    {
        return $this->current_members >= $this->max_members;
    }

    public function addMember()
    {
        $this->increment('current_members');
    }

    public function getAssistantOptions($query, $scope)
    {
         return User::where('role_id', 3)->pluck('first_name', 'id')->toArray();
    }
}
