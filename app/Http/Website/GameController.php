<?php

namespace App\Http\Website;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class GameController extends Controller
{
    public function index(Request $request) {
        $games = Post::select("id", "title","images", "slug_url", "package_id")->where("post_format", "game")->paginate(12);
        $last_page = $games->lastPage();
        $dataGames = "";
        if ($request->ajax()) {
            foreach($games as $game) {
                $title = json_decode($game->title, true);
                $title = Utils::get_value_language($title);
                $images_game = json_decode($game->images);
                $icon_game = asset($images_game->icon);
                $short_desc_game = json_decode($game->short_desc, true);
                $link_detail_game = route("games.detail", $game->slug_url);
                $link_install_game = route("games.install", $game->id);

            $dataGames .= " <div class='grid_col grid_col_4 new-game-item clearfix'>
            <div class='ce clearfix'>
                <div>
                    <div class='cws_fa_tbl'>
                        <div class='cws_fa_tbl_row'>
                            <div class='cws_fa_tbl_cell size_1x' style='width: calc(2em + 130px);'>
                                <div class='cws_fa_wrapper round' style='transform: translateY(-8px);'>
                                    <img src='$icon_game' alt='' style='border-radius: 15px;'>
                                </div>
                            </div>
                            <div class='cws_fa_tbl_cell'>
                                <a href='$link_detail_game'> <h2 style='height: 3em;
                                line-height: 1.5em;
                                overflow: hidden;
                                transform: translateY(-18px);
                                font-family: Patrick Hand !important;
                                '>$title</h2> </a>
                                <div class='link'>
                                    <a href='$link_install_game' style='display: inline-block;
                                    font-size: 1.3em;
                                    line-height: 1;
                                    padding: 8px 20px;
                                    border-radius: 7px;
                                    border: none;
                                    color: #fff;
                                    background: #26b4d7;
                                    font-size:20px;
                                    /* margin-top:10px; */
                                    ' class='cf-form-control cf-submit'><i style='font-size: 17px;' style='padding-right:10px' class='fa fa-download'></i>Install</a>
                                </div>

                            </div>

                        </div>
                        <div class='cws_fa_tbl_row'>
                            <div class='cws_fa_tbl_cell'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>";



            }
            return  $dataGames;
        }
        return view("client.games", compact("games", "last_page"));
    }
    public function detail(Request $request, $slug) {


        $game = Post::select("id","slug_url", "info_game","title","images", "content", "short_desc", "updated_at")->where("slug_url", $slug)->first();
        if(is_null($game)) {
            return view("errors.404");
        }
        //  // seo
        //  View::share("meta_desc", "Introduce the latest game products, character sets");
        //  View::share("meta_keywords", "game products, character sets, videos game");
        //  View::share("meta_title", "Wolfoogame - Game online for everyone");
        //  View::share("url_canonical", $request->url());
        //  //end seo
        $games_related =  Post::select("id","slug_url", "title","images", "content", "short_desc", "updated_at")
        ->where("post_format", "game")
        ->where("id", "<>", $game->id)
        ->latest()->limit(4)->get();
        return view("client.detail-game", compact("game", "games_related"));
    }
    public function install(Request $request, $idGame) {
        $game = Post::findOrFail($idGame);
        $packages = json_decode($game->package_id);
        $packageAndroid = $packages->android;
        $packageIphone = $packages->iphone;
        $user_agent = $request->server('HTTP_USER_AGENT');
        if(strpos($user_agent, "Win")) {
           return redirect("https://play.google.com/store/apps/details?id=$packageAndroid");
        }
        else if (strpos($user_agent, "Mac")) {
            return redirect("https://apps.apple.com/vn/app/bully-anniversary-edition/$packageIphone");
        }
        else if (preg_match('#android#i', $user_agent)) {
            return redirect('market://details?id='.$packageAndroid);
        }
        else if (preg_match('#(iPad|iPhone|iPod)#i', $user_agent)) {
            return redirect("itms://itunes.apple.com/us/app/google-maps-real-time-navigation/$packageIphone?mt=8");
        }
    }
}

