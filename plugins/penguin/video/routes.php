<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/secure/video/{path}', function ($path) {
    if (!Storage::disk('s3')->exists($path)) {
        abort(404, 'File not found');
    }

    $url = Storage::disk('s3')->temporaryUrl($path, now()->addSeconds(1));
    return response()->json(['url' => $url]);
})->where('path', '.*');
