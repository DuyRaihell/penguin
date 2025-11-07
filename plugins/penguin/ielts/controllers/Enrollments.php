<?php namespace Penguin\Ielts\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Enrollments extends Controller
{
    public $implement = ['Backend\Behaviors\ListController', 'Backend\Behaviors\FormController'];
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $requiredPermissions = ['penguin.ielts.access_enrollments'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Penguin.Ielts', 'ielts', 'enrollments');
    }
}
