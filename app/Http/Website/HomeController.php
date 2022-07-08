<?php

namespace App\Http\Website;

use App\Jobs\SendEmail;
use App\Models\Post;
use App\Models\Slider;
use App\Models\Config;
use App\Models\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public function __construct(Request $request)
    {
        // seo
        View::share("meta_desc", "Introduce the latest game products, character sets");
        View::share("meta_keywords", "game products, character sets, videos game");
        View::share("meta_title", "Wolfoogame - Game online for everyone");
        View::share("url_canonical", $request->url());
        //end seo
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index() {
        $languages = Config::get_languages();
        $sliderCollection = Slider::where("is_active",1)->limit(1)->first();
        $hot_games = Post::select("id","title","slug_url", "images", "short_desc")
        ->where("is_activate",1)
        ->where("post_format","game")
        ->where("is_hot",1)
        ->orderBy("id", "DESC")
        ->limit(3)->get();
        $feature_games = Post::select("id","slug_url","title","images", "short_desc")
        ->where("is_activate",1)
        ->where("post_format","game")
        ->where("is_feature",1)
        ->orderBy("id", "DESC")
        ->limit(6)->get();
        $new_games = Post::select("id","slug_url","title","images", "short_desc")
        ->where("is_activate",1)
        ->where("post_format","game")
        ->orderBy("id", "DESC")
        ->limit(6)->get();
        $new_videos = Post::select("id","slug_url","title","video_url")
        ->where("is_activate",1)
        ->where("post_format","video")
        ->orderBy("id", "DESC")
        ->limit(6)->get();

        foreach($new_videos as $new_video) {
            $new_video->video_url = explode("?v=", $new_video);
            $new_video->video_url = str_replace('"}', "",  $new_video->video_url[1]);
        }

        $sliders = explode(",",$sliderCollection->images);

        return view("client.index",compact("sliders","hot_games", "feature_games", "new_games", "new_videos"));
    }
    public function sendMessage(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'=>'required|max:255',
            'email'=>'required|email',
            'message'=>'required|max:255',
        ]);
        if($validator->fails()) {
            return response()->json([
                'errors'=>$validator->messages()
            ],HttpResponse::HTTP_BAD_REQUEST);
        }
        else {
              $message =   Message::create([
                "name"=>$request->name,
                "email"=>$request->email,
                "receipent"=>json_encode(Config::get_emails()),
                "content"=>$request->message,
            ]);

            SendEmail::dispatch($message)->delay(now()->addSeconds(15));

            return response()->json([
                'message'=>"You have successfully submitted your feedback",
            ],HttpResponse::HTTP_CREATED);
        }
    }
    public function changeLanguage($language) {
        if(Session::has("selected_lang")) {
            Session::forget("selected_lang");
        }
        Session::put("selected_lang", $language);
        return back();
    }
}
