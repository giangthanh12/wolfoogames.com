<?php

namespace App\Http\Website;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function index(Request $request) {
    $characters = Post::select("id", "title","images", "content", "slug_url")->where("post_format", "charactor")->latest()->get();
    if ($request->ajax()) {
        $data_character = "";
        foreach($characters as $character) {
            $title = json_decode($character->title, true);
            $title = array_key_exists('en', $title) ? $title['en'] : '';
            $images_character = json_decode($character->images);
            $icon_character = asset($images_character->icon);
            $link_detail_game = route("character.detail", $character->slug_url);

        $data_character .= "  <div class='grid_col grid_col_3 new-game-item clearfix'>
        <div class='ce clearfix'>
            <div style='transform: translateY(-8px);'>
            <a href='$link_detail_game' style='display:block'>
                <img src='$icon_character' alt='' style='border-radius: 15px; width:100%; aspect-ratio:1/1'>
            </a>
            </div>

            <div class='title-character' style='display:block; margin-top:0; text-align: center;'>
                <a href='$link_detail_game'>
                    <h2
                    style='
                    line-height: 1.5em;
                    overflow: hidden;
                    transform: translateY(-18px);
                    font-family: Patrick Hand !important;
                    '>
                    $title</h2>
                </a>
            </div>
            </div>
        </div>";
        }
        return  $data_character;
    }
    return view("client.characters", compact("characters"));
    }
    public function detail($slug) {
        $character = Post::select("id","slug_url","title","images", "content", "short_desc", "updated_at")->where("slug_url", $slug)->first();
        if(is_null($character)) {
            return view("errors.404");
        }
        $characters_related =  Post::select("id","slug_url", "title","images", "content", "short_desc", "updated_at")
        ->where("post_format", "charactor")
        ->where("id", "<>", $character->id)
        ->latest()->limit(4)->get();
        return view("client.detail-character", compact("character", "characters_related"));
    }

}

