<?php
/**
 * Here is your custom functions.
 */

use app\helper\MockApp;
use WebmanTech\LaravelCache\Facades\Cache;

if (! function_exists('app')) {
    function app($app = null, $params = null)
    {
        if ($app === 'cache') {
            return Cache::instance();
        }


        return new MockApp;
    }
}

if (! function_exists('url')) {
    function url(string $path = ''): string
    {
        return config('app.url') . '/' . ltrim($path, '/');
    }
}