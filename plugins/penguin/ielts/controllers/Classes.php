<?php

namespace Penguin\Ielts\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;
use Redirect;

class Classes extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\RelationController',
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = ['penguin.ielts.access_classes'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Penguin.Ielts', 'ielts', 'classes');
    }

    public function listExtendQuery($query)
    {
        $user = BackendAuth::getUser();
        if ($user && $user->role_id == 3) {
            $query->where('assistant_id', $user->id);
        }
    }

    public function update($recordId = null, $context = null)
    {
        $user = BackendAuth::getUser();

        // Check if user has edit permission
        if (!$user || !$user->hasPermission('penguin.ielts.access_courses')) {
            // Redirect to preview page
            return Redirect::to($this->actionUrl('preview', $recordId));
        }

        // Otherwise proceed normally
        return $this->asExtension('FormController')->update($recordId, $context);
    }
}
