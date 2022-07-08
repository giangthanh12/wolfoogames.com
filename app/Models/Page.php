<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'content',
    ];
    public static function checkSlug($slug) {
        $result = true;
        if(Page::where('slug',$slug)->count() > 0)
        $result = false;
        return $result;
        }
}
