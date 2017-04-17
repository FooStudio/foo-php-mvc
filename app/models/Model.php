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
        $all = static::$all;
        foreach ($all as $item) {
            if ($item->key_url == $id) {
                return static::toObject($item);
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
        static::validateLoaded();
        $object = new \stdClass();
        foreach ($array as $key => $value) {
            $object->$key = is_array($value) ? static::toObject($value) : $value;
        }
        return $object;
    }

    protected static function validateLoaded()
    {
        if (!static::$loaded) static::load();
    }
}