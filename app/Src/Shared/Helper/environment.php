<?php

if (! function_exists('is_local')) {
    function is_local()
    {
        return config('linguameeting.env') == 'local';
    }
}

if (! function_exists('is_develop')) {
    function is_develop()
    {
        return config('linguameeting.env') == 'dev';
    }
}

if (! function_exists('is_production')) {
    function is_production()
    {
        return config('linguameeting.env') == 'pro';
    }
}
