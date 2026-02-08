<?php

namespace Penguin\Ielts;

use Backend;
use Event;
use BackendAuth;
use System\Classes\PluginBase;
use Dashboard\Classes\DashManager;
use Penguin\Ielts\Reports\PaidCourseDataSource;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'IELTS Courses',
            'description' => 'Sell IELTS courses with RainLab.User and VNPAY.',
            'author'      => 'Penguin',
            'icon'        => 'icon-graduation-cap'
        ];
    }

    public function registerPermissions()
    {
        return [
            'penguin.ielts.access_courses' => [
                'tab' => 'IELTS',
                'label' => 'Access and manage courses',
            ],
            'penguin.ielts.access_enrollments' => [
                'tab' => 'IELTS',
                'label' => 'Access and manage enrollments',
            ],
            'penguin.ielts.access_classes' => [
                'tab' => 'IELTS',
                'label' => 'Access and manage classes',
            ],
            'penguin.ielts.access_tests' => [
                'tab'   => 'IELTS',
                'label' => 'Manage IELTS Tests'
            ],
            'penguin.ielts.access_questions' => [
                'tab'   => 'IELTS',
                'label' => 'Manage IELTS Questions'
            ],
            'penguin.ielts.access_attempts' => [
                'tab'   => 'IELTS',
                'label' => 'View Student Attempts'
            ],
            'penguin.ielts.grade_writing_speaking' => [
                'tab'   => 'IELTS',
                'label' => 'Grade Writing & Speaking'
            ]
        ];
    }

    public function registerNavigation()
    {
        return [
            'ielts' => [
                'label'       => 'IELTS',
                'url'         => \Backend::url('penguin/ielts/courses'),
                'icon'        => 'icon-graduation-cap',
                'permissions' => [
                    'penguin.ielts.access_courses',
                    'penguin.ielts.access_classes',
                    'penguin.ielts.access_enrollments'
                ],
                'order'       => 500,

                'sideMenu' => [
                    'courses' => [
                        'label'       => 'Courses',
                        'icon'        => 'icon-graduation-cap',
                        'url'         => \Backend::url('penguin/ielts/courses'),
                        'permissions' => ['penguin.ielts.access_courses']
                    ],
                    'classes' => [
                        'label'       => 'Classes',
                        'icon'        => 'icon-book',
                        'url'         => \Backend::url('penguin/ielts/classes'),
                        'permissions' => ['penguin.ielts.access_classes']
                    ],
                    'tests' => [
                        'label'       => 'Tests',
                        'icon'        => 'icon-list',
                        'url'         => \Backend::url('penguin/ielts/tests'),
                        'permissions' => ['penguin.ielts.access_tests']
                    ],

                    'questions' => [
                        'label'       => 'Questions',
                        'icon'        => 'icon-question-circle',
                        'url'         => \Backend::url('penguin/ielts/questions'),
                        'permissions' => ['penguin.ielts.access_questions']
                    ],

                    'attempts' => [
                        'label'       => 'Attempts',
                        'icon'        => 'icon-users',
                        'url'         => \Backend::url('penguin/ielts/attempts'),
                        'permissions' => ['penguin.ielts.access_attempts']
                    ],

                    // 'grading' => [
                    //     'label'       => 'Grading',
                    //     'icon'        => 'icon-check-square-o',
                    //     'url'         => \Backend::url('penguin/ielts/grading'),
                    //     'permissions' => ['penguin.ielts.grade_writing_speaking']
                    // ]
                ]
            ]
        ];
    }


    public function registerComponents()
    {
        return [
            'Penguin\Ielts\Components\Courses' => 'courses',
            'Penguin\Ielts\Components\MyCourses' => 'myCourses',
            'Penguin\Ielts\Components\PaymentReturn' => 'paymentReturn',
            'Penguin\Ielts\Components\Tests' => 'ieltsTests',
        ];
    }

    public function boot()
    {
        \Event::listen('backend.page.beforeDisplay', function ($controller, $action, $params) {

            $user = \BackendAuth::getUser();
            if (!$user) {
                return;
            }

            // If request is exactly /admin
            $path = \Request::path();
            if ($path === 'backend' || $path === 'admin') {

                // User has only access_classes
                $hasClasses = $user->hasPermission('penguin.ielts.access_classes');
                $hasCourses = $user->hasPermission('penguin.ielts.access_courses');

                if ($hasClasses && !$hasCourses) {
                    return \Redirect::to(\Backend::url('penguin/ielts/classes'));
                }
            }
        });
        
        Event::listen('backend.menu.extendItems', function ($manager) {

            $user = BackendAuth::getUser();
            if (!$user) {
                return;
            }

            // Show Settings only for super admin
            if (!$user->is_superuser) {
                $manager->removeMainMenuItem('October.System', 'system');
            }
        });

        DashManager::instance()->registerDataSourceClass(
            PaidCourseDataSource::class,
            'Paid Course Revenue'
        );
    }
}
