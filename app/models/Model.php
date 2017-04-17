<?php

namespace App\Models;

/**
 * Class Model
 * @package App\Models
 */
class Model
{
    /**
     * @var \stdClass
     */
    protected static $all;

    /**
     * @default false
     * @var bool
     */
    protected static $loaded = false;

    /**
     * @var string
     */
    protected static $name;


    private static function load()
    {
        static::$loaded = true;
        $data = json_decode(file_get_contents('./db/' . static::$name . '.json'), true);
        static::$all = static::toObject($data);
    }

    /**
     * @return \stdClass
     */
    public static function all()
    {
        static::validateLoaded();
        return static::$all;
    }

    /**
     * @param string $id
     * @return \stdClass
     */
    public static function find($id)
    {
        static::validateLoaded();
        foreach (static::$all as $item) {
            if ($item->key_url == $id) {
                return $item;
            }
        }
        unset($item);
    }

    /**
     * @param array $array
     * @return \stdClass
     */
    protected static function toObject($array)
    {
        return json_decode(json_encode($array), FALSE);
    }

    protected static function validateLoaded()
    {
        if (!static::$loaded) static::load();
    }
}