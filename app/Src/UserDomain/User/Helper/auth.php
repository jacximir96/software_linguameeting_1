<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('user')) {
    function user()
    {
        return (Auth::check()) ? Auth::user() : null;
    }
}

if (! function_exists('user_is_admin')) {
    function user_is_admin()
    {
        $user = user();

        if ($user){
            return $user->isAdmin();
        }

        return false;
    }
}
