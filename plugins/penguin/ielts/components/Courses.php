<?php

namespace Penguin\Ielts\Components;

use Cms\Classes\ComponentBase;
use Penguin\Ielts\Models\Course;
use Penguin\Vnpay\Classes\VnpayService;
use Penguin\Ielts\Models\Enrollment;
use Auth;

class Courses extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Courses',
            'description' => 'Displays IELTS courses with Buy button.'
        ];
    }

    public function onRun()
    {
        $this->page['courses'] = Course::all();
    }

    public function onEnroll()
    {
        $courseId = post('course_id');
        $course = Course::find($courseId);
        $user = Auth::getUser();

        if (!$user) {
            throw new \ApplicationException('Please log in first.');
        }

        $vnpay = new VnpayService();
        $enrollment = Enrollment::updateOrCreate(
            ['user_id' => $user->id, 'course_id' => $courseId],
            [
                'payment_status' => 'pending',
            ]
        );

        $redirectUrl = $vnpay->createPaymentUrl($enrollment->id, $course->price, "Buy {$course->title}");

        return redirect($redirectUrl);
    }
}
