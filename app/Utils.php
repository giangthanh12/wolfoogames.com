<?php

namespace App;

use Exception;

class Utils {

    /*
     * Replace first match.
     * replace search only first match by replace in subject
     * */
    public static function str_replace_first($search, $replace, $subject) {
        if (is_null($subject) || empty($subject)) return $subject;
        $search = '/'.preg_quote($search, '/').'/';
        return preg_replace($search, $replace, $subject, 1);
    }

    public static function get_array_item_value($array_key, $array, $default_val=null) {
        if (array_key_exists($array_key, $array)) {
            return $array[$array_key];
        } else {
            return $default_val;
        }
    }
    public static function get_value_language($value) {
        $result = array_key_exists("en", $value) ? $value["en"] : '';
        if(session()->has("selected_lang")) {
            $selected_lang = session()->get("selected_lang");
            $result = array_key_exists($selected_lang, $value) ? $value[$selected_lang] : '';
            if(empty($result)) {
                $result = array_key_exists("en", $value) ? $value["en"] : '';
            }
        }
        return $result;

    }


}
