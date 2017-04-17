<?php

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

if (!function_exists('view')) {

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