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

class NewsController extends PostController
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
        $news_list = null;

        try {
            $news_list = Post::select('id', 'title', 'images', 'short_desc', 'is_activate', 'slug_url', 'view_count', 'user_id', 'created_at', 'updated_at')
                ->where(['post_type'=>Constants::POST_TYPE_POST, 'post_format'=>Constants::POST_FORMAT_DEFAULT])
                ->where('title', 'like', '%'.$search.'%')
                ->orderBy('id', 'desc')->paginate(15);

        } catch (Exception $e) {
        }
        return view('admin.news')->with(compact('languages', 'news_list', 'page', 'search'));
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

        return view('admin.news-add')->with(compact('languages', 'selected_lang'));
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
        $post = null;
        try {
            $post = Post::find($request->input('id', 0));
        } catch(Exception $e) {

        }

        return view('admin.news-edit')->with(compact('languages', 'selected_lang', 'post'));
    }

    public function save(Request $request) {
        $post_id = $request->input('post_id', 0);
        $post = Post::find($post_id);
        if (strtoupper($request->method()) !== 'POST') return 'invalid';
        try {
            $messages = [
                'short-desc.required'  => '(*) Summary is required',
                'title.required'  => '(*) Post title is required',
                'content.required'  => '(*) Description is required',
                'feature-image.required'  => '(*) Feature image is required',
            ];

            $validator = Validator::make($request->all(), [
                'short-desc' => 'required',
                'title' => 'required|string|max:100',
                'content' => 'required',
                'feature-image' => 'required',
            ], $messages);

            if ($validator->fails()) {
                \Session::flash('msg', 'Post save unsuccessful!' );
                \Session::flash('status', 'fail' );
                 return redirect()->back()->withErrors($validator)->withInput();
            }

            $post_id = $request->input('post_id', 0);
            $language = $request->input('language', 'en');
            $short_desc = $request->input('short-desc');
            $title = $request->input('title');
            $content = $request->input('content');
            $feature_image = $request->input('feature-image');
            $feature_image = Utils::str_replace_first(config('app.url'), '', $feature_image);
            $exist_slug = false;

            if (is_numeric($post_id) && $post_id > 0) {
                $post = Post::find($post_id);
                $exist_slug = true;
                $arr_title = json_decode($post->title, true);
                $arr_short = json_decode($post->short_desc, true);
                $arr_content = json_decode($post->content, true);
            } else {
                $post = new Post();
                $arr_title = array();
                $arr_short = array();
                $arr_content = array();
                $slug = Str::slug($title);
                $post->slug_url = $slug;
            }
            $arr_title[$language] = $title;
            $arr_short[$language] = $short_desc;
            $arr_content[$language] = $content;

            $post->post_type = Constants::POST_TYPE_POST;
            $post->post_format = Constants::POST_FORMAT_DEFAULT;
            $post->title = json_encode($arr_title);
            $post->short_desc = json_encode($arr_short);
            $post->content = json_encode($arr_content);
            $post->images = $feature_image;
            $post->user_id = Auth::user()->id;
            $post->save();

            if (!$exist_slug) {
                $post->slug_url .= '-'.$post->id;
                $post->save();
            }

            /* seo of post */
            $this->save_seo_post($request, $post->id, $language);

            \Session::flash('msg', 'Post saved successful.' );
            \Session::flash('status', 'success' );
        } catch (Exception $e) {
            $validator = Validator::make([], []);
            $validator->getMessageBag()->add('unknown_exception', 'Error: ' . $e->getMessage());
            \Session::flash('msg', 'Post save unsuccessful!' );
            \Session::flash('status', 'fail' );
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return redirect('/content/news');
    }

    public function delete_news(Request $request) {
        try {
            Post::destroy($request->input('id', 0));
            \Session::flash('msg', 'Post deleted successful.' );
            \Session::flash('status', 'success' );
        } catch (Exception $e) {
            \Session::flash('msg', 'Post delete unsuccessful!' );
            \Session::flash('status', 'fail' );
        }

        return redirect('/content/news');
    }
}
