<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $primaryKey = 'cfg_key';
    public $timestamps = false;

    protected $fillable = [
        'cfg_key',
        'cfg_value'
    ];

    public static function get_languages() {
        $record_language = Config::where('cfg_key', 'languages')->first();
        $languages = ['en'];
        try {
            if (is_null($record_language)) {
                $record_language = new Config();
                $record_language->cfg_key = 'languages';
                $record_language->cfg_value = 'en';
                $record_language->save();
            }
            $languages = explode(';', $record_language->cfg_value);
        } catch (Exception $e) {}
        return $languages;
    }
    public static function get_content() {
        $content_about = Config::where('cfg_key', 'about')->pluck("cfg_value")->first();
        return $content_about;
    }
    public static function get_emails() {
        $emails_config = Config::select("cfg_value")->where("cfg_key", "emails")->first();
        $selected_emails = [];
        if(!is_null($emails_config))
        $selected_emails = json_decode($emails_config->cfg_value);
        return $selected_emails;
    }
}
