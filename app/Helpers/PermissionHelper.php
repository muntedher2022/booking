<?php

if (!function_exists('hasRole')) {
    function hasRole($user, $roles) {
        return $user->hasAnyRole((array)$roles);
    }
}
