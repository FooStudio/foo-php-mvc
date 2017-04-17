<?php

use Illuminate\Support\Str;

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string $key
     * @param  string $default
     * @return string
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if (strlen($value) > 1 && Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

if (!function_exists('view')) {
    /**
     * @param null $view
     * @param array $data
     * @param array $mergeData
     * @return string
     */
    function view($view = null, $data = [], $mergeData = [])
    {

        if (func_num_args() === 0) {
            echo '';
        }

        echo $GLOBALS['blade']->make($view, $data, $mergeData);
    }
}

if (!function_exists('url')) {

    /**
     * @param $routeName
     * @param array $params
     * @return string
     */
    function url($routeName, $params = [])
    {

        if (func_num_args() === 0) {
            echo '';
        }

        echo $GLOBALS['router']->generate($routeName, $params);
    }
}