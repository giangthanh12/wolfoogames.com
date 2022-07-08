<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostSeo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'seo_title',
        'seo_keyword',
        'seo_description'
    ];
}
