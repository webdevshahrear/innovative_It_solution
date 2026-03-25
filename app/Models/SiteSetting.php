<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['setting_key', 'setting_value', 'display_name', 'group'];

    protected static $cache = [];

    public static function getValue($key, $default = null)
    {
        if (array_key_exists($key, self::$cache)) {
            return self::$cache[$key];
        }

        $setting = self::where('setting_key', $key)->first();
        self::$cache[$key] = $setting ? $setting->setting_value : $default;
        
        return self::$cache[$key];
    }
}
