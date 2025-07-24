<?php

if (!function_exists('session_user')) {
    /**
     * optiene el usuario actual de la sesión
     */
    function session_user()
    {
        try {
            if (app()->bound('session') && session()->has('user')) {
                return (object) session()->get('user');
            }
        } catch (\Exception $e) {
            // sesison no está disponible
        }
        return null;
    }
}

if (!function_exists('is_authenticated')) {
    /**
     * Checa si el usuario está autenticado
     */
    function is_authenticated()
    {
        try {
            if (app()->bound('session')) {
                return session()->has('authenticated') && session()->get('authenticated') === true;
            }
        } catch (\Exception $e) {
            // sesison no está disponible
        }
        return false;
    }
}
