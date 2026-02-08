<?php

namespace Penguin\Ielts\Components;

use Cms\Classes\ComponentBase;
use Penguin\Ielts\Models\Test;
use Penguin\Ielts\Models\Attempt;
use Penguin\Ielts\Models\AttemptAnswer;
use Input;
use Redirect;
use Auth;
use Session;
use Storage;

class Tests extends ComponentBase
{
    public $test;
    public $attempt;

    public function componentDetails()
    {
        return [
            'name' => 'IELTS Tests',
            'description' => 'List and take IELTS tests'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title' => 'Test slug',
                'default' => '{{ :slug }}',
                'type' => 'string'
            ]
        ];
    }

    /**
     * Test list page
     */
    public function tests()
    {
        return Test::withCount('questions')->get();
    }

    /**
     * Single test page
     */
    public function test()
    {
        return $this->test = Test::where('slug', $this->property('slug'))
            ->with([
                'questions.answers',
            ])
            ->firstOrFail();
    }

    public function onRun()
    {
        // Only create attempt on test page
        if (!$this->property('slug')) {
            return;
        }

        $test = Test::where('slug', $this->property('slug'))->first();
        if (!$test) {
            return;
        }

        // Prevent duplicate active attempts
        if (Session::has('current_attempt_id')) {
            return;
        }

        $this->attempt = Attempt::create([
            'test_id'    => $test->id,
            'user_id'    => Auth::getUser()?->id,
            'session_id' => Session::getId(),
            'started_at' => now(),
            'created_at' => now(),
        ]);

        Session::put('current_attempt_id', $this->attempt->id);
    }

    /**
     * Handle submit
     */
    public function onSubmitTest()
    {
        $attemptId = Session::get('current_attempt_id');

        if (!$attemptId) {
            throw new \Exception('Attempt not found.');
        }

        $test = Test::with('questions.answers')
            ->where('slug', $this->property('slug'))
            ->first();

        if (!$test) {
            throw new \ApplicationException('Test not found.');
        }
        foreach ($test->questions as $question) {

            $attemptAnswer = new AttemptAnswer();
            $attemptAnswer->attempt_id  = $attemptId;
            $attemptAnswer->question_id = $question->id;

            // 1️⃣ Multiple choice
            if ($question->answer_type === 'choice') {
                $attemptAnswer->answer_id = post('answers')[$question->id] ?? null;
            }

            // 2️⃣ Text input
            if ($question->answer_type === 'text') {
                $attemptAnswer->answer_text = post('answers_text')[$question->id] ?? null;
            }

            if (
                $question->answer_type === 'file'
                && Input::hasFile("answers_file.{$question->id}")
            ) {
                $file = Input::file("answers_file.{$question->id}");
            
                // Upload to S3
                $path = Storage::disk('s3')->putFile(
                    'ielts_attempts',
                    $file,
                    'private' // or 'public'
                );
            
                $attemptAnswer->answer_file = $path;
            }

            $attemptAnswer->save();
        }

        // mark attempt submitted
        Attempt::where('id', $attemptId)->update([
            'submitted_at' => now(),
        ]);

        Session::forget('current_attempt_id');
        return Redirect::to('/ielts-tests');
    }
}
