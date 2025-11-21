<?php

namespace Penguin\Ielts;

use Backend;
use Event;
use BackendAuth;
use System\Classes\PluginBase;

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
                    ]
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
        ];
    }

    public function boot()
    {
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
    }
}
