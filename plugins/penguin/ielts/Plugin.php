<?php

namespace Penguin\Ielts;

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
        ];
    }

    public function registerNavigation()
    {
        return [
            'ielts' => [
                'label'       => 'IELTS',
                'url'         => \Backend::url('penguin/ielts/courses'),
                'icon'        => 'icon-graduation-cap',
                'permissions' => ['penguin.ielts.*'],
                'order'       => 500,

                'sideMenu' => [
                    'courses' => [
                        'label'       => 'Courses',
                        'icon'        => 'icon-book',
                        'url'         => \Backend::url('penguin/ielts/courses'),
                        'permissions' => ['penguin.ielts.access_courses']
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
}
