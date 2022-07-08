<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function post_seo() {
        return $this->hasOne(PostSeo::class, 'post_id');
    }

    public function poster() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function get_duration() {
        $short_desc = (array) json_decode($this->short_desc);
        if(!array_key_exists("duration", $short_desc)) return "";
        return $short_desc["duration"];
    }
    public function get_channel() {
        $short_desc = (array) json_decode($this->short_desc);
        if(!array_key_exists("channel", $short_desc)) return "";
        return $short_desc["channel"];
    }
}
