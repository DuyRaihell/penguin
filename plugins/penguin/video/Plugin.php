<?php

namespace Penguin\Video;

use System\Classes\PluginBase;
use Penguin\Video\Components\VideoList;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Event;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'Video',
            'description' => 'Secure video streaming for your site',
            'author' => 'Penguin',
            'icon' => 'icon-video'
        ];
    }

    public function registerComponents()
    {
        return [
            VideoList::class => 'videoList'
        ];
    }
}
