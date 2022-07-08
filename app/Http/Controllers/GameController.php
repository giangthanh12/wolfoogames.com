<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use Session;
use Auth;

use App\Models\Post;
use App\Models\PostSeo;
use App\Models\Config;
use App\NetworkUtils;
use App\Constants;
use App\Utils;

class GameController extends PostController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(Request $request) {
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $languages = Config::get_languages();
        $game_list = null;

        try {
            $game_list = Post::select('id', 'title', 'images', 'package_id', 'is_activate', 'slug_url', 'view_count', 'user_id', 'created_at', 'updated_at')
                ->where(['post_type'=>Constants::POST_TYPE_POST, 'post_format'=>Constants::POST_FORMAT_GAME])
                ->where('title', 'like', '%'.$search.'%')
                ->orderBy('id', 'desc')->paginate(15);
        } catch (Exception $e) {
        }
        return view('admin.game')->with(compact('languages', 'game_list', 'page', 'search'));

    }

    public function show_add_form(Request $request) {
        $cfg_languages = Config::get_languages();
        $languages = [Constants::DEFAULT_LANGUAGE => Constants::DEFAULT_LANG_NAME];
        if (!is_null($cfg_languages) && count($cfg_languages) > 0) {
            foreach($cfg_languages as $lang_code) {
                $languages[$lang_code] = Constants::LANGUAGES[$lang_code];
            }
        }
        $selected_lang = $request->input('language', Constants::DEFAULT_LANGUAGE);

        return view('admin.game-add')->with(compact('languages', 'selected_lang'));
    }

    public function show_edit_form(Request $request) {
        $cfg_languages = Config::get_languages();
        $languages = [Constants::DEFAULT_LANGUAGE => Constants::DEFAULT_LANG_NAME];
        if (!is_null($cfg_languages) && count($cfg_languages) > 0) {
            foreach($cfg_languages as $lang_code) {
                $languages[$lang_code] = Constants::LANGUAGES[$lang_code];
            }
        }
        $selected_lang = $request->input('language', Constants::DEFAULT_LANGUAGE);
        $game = null;
        try {
            $game = Post::find($request->input('id', 0));
        } catch(Exception $e) {

        }

        return view('admin.game-edit')->with(compact('languages', 'selected_lang', 'game'));
    }

    public function save(Request $request) {
        if (strtoupper($request->method()) !== 'POST') return 'invalid';
        try {
            $messages = [
                'icon-image.required'  => '(*) Icon is required',
                'feature-image.required'  => '(*) Feature image is required',
                'package-android.required'  => '(*) Android package name is required',
                'package-iphone.required'  => '(*) iPhone package name is required',
                'title.required'  => '(*) Title is required',
                'short-desc.required'  => '(*) Short description is required',
                'content.required'  => '(*) Description is required',
            ];

            $validator = Validator::make($request->all(), [
                'package-android' => 'required|string',
                'package-iphone' => 'required|string',
                'title' => 'required|string|max:100',
                'short-desc' => 'required|string|max:512',
                'content' => 'required',
                'icon-image' => 'required',
                'feature-image' => 'required',
            ], $messages);

            if ($validator->fails()) {
                \Session::flash('msg', 'Game save unsuccessful!' );
                \Session::flash('status', 'fail' );
                 return redirect()->back()->withErrors($validator)->withInput();
            }

            $post_id = $request->input('post_id', 0);
            $language = $request->input('language', 'en');
            $android_pkg = $request->input('package-android');
            $iphone_pkg = $request->input('package-iphone');
            $title = $request->input('title');
            $short_desc = $request->input('short-desc');
            $content = $request->input('content');
            $icon_image = $request->input('icon-image');
            $feature_image = $request->input('feature-image');
            $rating = $request->input("rating", "");
            $downloads = $request->input("downloads", "");
            $reviews = $request->input("reviews", "");
            // $icon_image = Utils::str_replace_first(config('app.url'), '', $icon_image);
            // $feature_image = Utils::str_replace_first(config('app.url'), '', $feature_image);
            $is_hot = $request->input("game-hot", 0);
            $is_feature = $request->input("game-feature", 0);
            $exist_slug = false;

            if (is_numeric($post_id) && $post_id > 0) {
                $post = Post::find($post_id);
                $exist_slug = true;
                $arr_info_game = json_decode($post->info_game, true);
                $arr_title = json_decode($post->title, true);
                $arr_short = json_decode($post->short_desc, true);
                $arr_content = json_decode($post->content, true);
            } else {
                $post = new Post();
                $arr_info_game = array();
                $arr_title = array();
                $arr_short = array();
                $arr_content = array();
                $slug = Str::slug($title);
                $post->slug_url = $slug;
            }
            $arr_title[$language] = $title;
            $arr_short[$language] = $short_desc;
            $arr_content[$language] = $content;
            $arr_info_game["reviews"] = $reviews;
            $arr_info_game["downloads"] = $downloads;
            $arr_info_game["rating"] = $rating;
            $post->post_type = Constants::POST_TYPE_POST;
            $post->post_format = Constants::POST_FORMAT_GAME;
            $post->package_id = json_encode(array('android' => $android_pkg, 'iphone' => $iphone_pkg));
            $post->title = json_encode($arr_title);
            $post->short_desc = json_encode($arr_short);
            $post->content = json_encode($arr_content);
            $post->images = json_encode(array('icon' => $icon_image, 'feature' => $feature_image));
            $post->info_game = json_encode($arr_info_game);
            $post->user_id = Auth::user()->id;
            $post->is_hot = $is_hot;
            $post->is_feature = $is_feature;
            $post->save();

            if (!$exist_slug) {
                $post->slug_url .= '-'.$post->id;
                $post->save();
            }

            /* seo of post */
            $this->save_seo_post($request, $post->id, $language);

            \Session::flash('msg', 'Game saved successful.' );
            \Session::flash('status', 'success' );
        } catch (Exception $e) {
            $validator = Validator::make([], []);
            $validator->getMessageBag()->add('unknown_exception', 'Error: ' . $e->getMessage());
            \Session::flash('msg', 'Game save unsuccessful!' );
            \Session::flash('status', 'fail' );
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return redirect('/content/game');
    }

    public function delete_game(Request $request) {

        try {
            Post::destroy($request->input('id', 0));
            \Session::flash('msg', 'Game deleted successful.' );
            \Session::flash('status', 'success' );
        } catch (Exception $e) {
            \Session::flash('msg', 'Game delete unsuccessful!' );
            \Session::flash('status', 'fail' );
        }

        return redirect('/content/game');
    }

    /*
    serpapi.com private key: 548c9b53baf27c8754fabf267903698cfeb41dece6f8ac6a26fdda3698d6da8d
    ==> chua hoan thanh
    */
    public function get_play_info(Request $request) {
        $data = array();
        // $package = $request->input('pkg', '');
        // $url = 'https://serpapi.com/search.json?engine=google_play_product&store=apps'
        // . '&api_key=548c9b53baf27c8754fabf267903698cfeb41dece6f8ac6a26fdda3698d6da8d'
        // . '&product_id=' . $package;
        // $content = NetworkUtils::fetch_content_from_url($url);
        // return print_r($content);
        try {
            $package = $request->input('pkg', '');
            // $url = 'https://play.google.com/store/apps/details?id=' . $package;
            $url = 'https://serpapi.com/search.json?engine=google_play_product&store=apps'
                . '&api_key=548c9b53baf27c8754fabf267903698cfeb41dece6f8ac6a26fdda3698d6da8d'
                . '&product_id=' . $package;

            $content = NetworkUtils::fetch_content_from_url($url);
            $data['status'] = 'success';
            $data['package'] = $package;
            $data['content'] = $content;
            // $data['content_game'] = str_replace("\n", "<br/>", $content->about_this_game->snippet);
        } catch (Exception $e) {
            $data['status'] = 'fail';
        }
        // print_r($data['content']);
        // return;
        return response()->json($data);
    }
}
