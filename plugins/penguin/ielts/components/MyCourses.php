<?php namespace Penguin\Ielts\Components;

use Cms\Classes\ComponentBase;
use Auth;
use Penguin\Ielts\Models\Enrollment;

class MyCourses extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'My Courses',
            'description' => 'Displays courses the logged-in user has purchased.'
        ];
    }

    public function onRun()
    {
        $user = Auth::getUser();
        if (!$user) {
            return redirect('/login');
        }

        $this->page['enrollments'] = Enrollment::with('course')
            ->where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->get();
    }
}
