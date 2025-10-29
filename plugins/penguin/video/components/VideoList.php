<?php namespace Penguin\Video\Components;

use Cms\Classes\ComponentBase;
use Storage;

class VideoList extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Video List',
            'description' => 'Displays videos from protected S3 storage.'
        ];
    }

    public function onRun()
    {
        $this->page['videos'] = $this->loadVideos();
    }

    protected function loadVideos()
    {
        $files = Storage::disk('s3')->files('videos');
        
        $videos = [];
        foreach ($files as $file) {
            $videos[] = [
                'name' => basename($file),
                'url'  => $file
            ];
        }

        return $videos;
    }
}
