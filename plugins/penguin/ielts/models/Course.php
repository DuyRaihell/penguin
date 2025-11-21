<?php

namespace Penguin\Ielts\Models;

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
        'lessions'    => [Lession::class],
    ];

    public function afterSave()
    {
        $lessionsData = post('Course.lessions');

        if (!$lessionsData) {
            return;
        }

        // Delete old lessions
        $this->lessions()->delete();

        foreach ($lessionsData as $item) {
            $this->lessions()->create([
                'title' => $item['title'] ?? '',
                'description' => $item['description'] ?? '',
                'document' => $item['document'] ?? null,  // store path/url
                'course_id' => $this->id,
            ]);
        }
    }   
}
