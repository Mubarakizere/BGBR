<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {
    /**
     * Get a setting from the database, caching it for performance.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        $settings = Cache::rememberForever('system_settings', function () {
            return Setting::pluck('value', 'key')->all();
        });

        return array_key_exists($key, $settings) ? $settings[$key] : $default;
    }
}
