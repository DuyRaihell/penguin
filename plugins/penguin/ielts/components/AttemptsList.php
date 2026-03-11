<?php namespace Penguin\Ielts\Components;

use Cms\Classes\ComponentBase;
use Penguin\Ielts\Models\Attempt;

class AttemptsList extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Attempts List',
            'description' => 'Provides a list of attempts for listing and linking to results.'
        ];
    }

    public function defineProperties()
    {
        return [
            'limit' => [
                'title' => 'Limit',
                'description' => 'Maximum number of attempts to return (0 = all)',
                'default' => 0,
                'type' => 'string',
            ],
            'userOnly' => [
                'title' => 'Current user only',
                'description' => 'Show attempts only for the currently logged in user',
                'default' => 0,
                'type' => 'checkbox',
            ],
        ];
    }

    public function onRun()
    {
        $this->page['attempts'] = $this->loadAttempts();
    }

    protected function loadAttempts()
    {
        $query = Attempt::with('test');

        $userOnly = (bool) $this->property('userOnly');
        if ($userOnly && \Auth::check()) {
            $query->where('user_id', \Auth::id());
        }

        $limit = (int) $this->property('limit');
        if ($limit > 0) {
            return $query->orderBy('submitted_at', 'desc')->limit($limit)->get();
        }

        return $query->orderBy('submitted_at', 'desc')->get();
    }
}
