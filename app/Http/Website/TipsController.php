<?php

namespace App\Http\Website;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class TipsController extends Controller
{
    public function index(Request $request) {
      $tips = Post::select("id","slug_url", "title","images", "short_desc", "updated_at")->where("post_format", "default")->paginate(6);
      return view("client.tips", compact("tips"));
    }
    public function detail($slug) {
        $tip = Post::select("id","slug_url", "title","images", "content", "short_desc", "updated_at")->where("slug_url", $slug)->first();
        if(is_null($tip)) {
            return view("errors.404");
        }
        $tips_related =  Post::select("id","slug_url", "title","images", "content", "short_desc", "updated_at")
        ->where("post_format", "default")
        ->where("id", "<>", $tip->id)
        ->latest()->limit(4)->get();
        return view("client.detail-tip", compact("tip", "tips_related"));
    }
}

