<?php

namespace App\Http\Website;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Page;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index() {
        $content_about = Page::where("slug", "about")->value("content");

        return view("client.about", compact("content_about"));
    }

}

