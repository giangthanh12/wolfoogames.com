<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'image',
        'link',
    ];
    public static function show_channel_footer() {
        $channels = Channel::select("title", "link", "image")->latest()->limit(5)->get();
        return $channels;
    }
}
