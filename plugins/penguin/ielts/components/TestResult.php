<?php

namespace Penguin\Ielts\Components;

use Cms\Classes\ComponentBase;
use Penguin\Ielts\Models\Attempt;
use Penguin\Ielts\Models\AttemptAnswer;
use Auth;
use Session;
use Redirect;
use ApplicationException;

class TestResult extends ComponentBase
{
    public $attempt;

    public function componentDetails()
    {
        return [
            'name' => 'Test Result',
            'description' => 'Displays a test attempt result and allows saving teacher comments'
        ];
    }

    public function defineProperties()
    {
        return [
            'id' => [
                'title' => 'Attempt id',
                'default' => '{{ :id }}',
                'type' => 'string',
            ],
        ];
    }

    public function onRun()
    {
        $id = input('id') ?: $this->property('id') ?: param('id');
        if (!$id) {
            return;
        }

        $this->attempt = Attempt::with(['answers.question', 'answers.answer'])->find($id);
        if (!$this->attempt) {
            return;
        }

        // Basic access control: allow owner (logged-in user) or same session
        $currentUser = Auth::getUser();
        $sessionId = Session::getId();

        $isOwner = $currentUser && $this->attempt->user_id && $currentUser->id == $this->attempt->user_id;
        $isSameSession = $this->attempt->session_id && $this->attempt->session_id == $sessionId;

        if (!$isOwner && !$isSameSession) {
            // Not allowed to view this attempt
            // Do not expose attempt to page
            $this->attempt = null;
            return;
        }

        $this->page['attempt'] = $this->attempt;
    }

    public function onSaveComments()
    {
        // Expect posted structure: answers[attempt_answer_id][comment]
        $posted = post('answers');
        if (!is_array($posted)) {
            throw new ApplicationException('No comments submitted.');
        }

        foreach ($posted as $id => $fields) {
            if (!isset($fields['comment'])) {
                continue;
            }

            $attemptAnswer = AttemptAnswer::find($id);
            if (!$attemptAnswer) {
                continue;
            }

            // Ensure the answer belongs to the attempt being viewed (if available)
            if ($this->attempt && isset($attemptAnswer->attempt_id) && $attemptAnswer->attempt_id != $this->attempt->id) {
                continue;
            }

            $attemptAnswer->comment = $fields['comment'];
            $attemptAnswer->save();
        }

        // Optionally redirect back or return a success message
        return Redirect::back();
    }
}
