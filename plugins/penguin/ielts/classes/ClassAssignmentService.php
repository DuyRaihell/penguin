<?php

namespace Penguin\Ielts\Classes;

use Penguin\Ielts\Models\ClassModel;
use Penguin\Ielts\Models\Course;

class ClassAssignmentService
{
    public function assignUserToClass($courseId)
    {
        // Try to find the first available class with space
        $class = $this->getClass($courseId);

        // Increase member count
        $class->addMember();

        return $class;
    }

    public function getClass($courseId)
    {
        $course = Course::find($courseId);
        
        if (!$course) {
            throw new \ApplicationException('Course not found.');
        }

        $class = ClassModel::where('course_id', $courseId)
            ->whereColumn('current_members', '<', 'max_members')
            ->orderBy('id')
            ->first();

        if (!$class) {
            $classNumber = ClassModel::where('course_id', $courseId)->count() + 1;
            $class = ClassModel::create([
                'course_id' => $courseId,
                'name' => "{$course->title} - Class {$classNumber}",
                'max_members' => $course->max_in_class ?? 20,
                'current_members' => 0,
            ]);
        }

        return $class;
    }
}
