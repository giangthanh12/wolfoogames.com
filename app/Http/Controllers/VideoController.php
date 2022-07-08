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

class VideoController extends PostController
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
        $video_list = null;

        try {
            $video_list = Post::select('id', 'title', 'images', 'short_desc', 'video_url', 'is_activate', 'slug_url', 'view_count', 'user_id', 'created_at', 'updated_at')
                ->where(['post_type'=>Constants::POST_TYPE_POST, 'post_format'=>Constants::POST_FORMAT_VIDEO])
                ->where('title', 'like', '%'.$search.'%')
                ->orderBy('id', 'desc')->paginate(15);

        } catch (Exception $e) {
        }
        return view('admin.video')->with(compact('languages', 'video_list', 'page', 'search'));
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

        return view('admin.video-add')->with(compact('languages', 'selected_lang'));
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
        $video = null;
        try {
            $video = Post::find($request->input('id', 0));
        } catch(Exception $e) {

        }

        return view('admin.video-edit')->with(compact('languages', 'selected_lang', 'video'));
    }

    public function save(Request $request) {
        if (strtoupper($request->method()) !== 'POST') return 'invalid';
        try {
            $messages = [
                'video-url.required'  => '(*) Video url is required',
                'title.required'  => '(*) Video title is required',
                'content.required'  => '(*) Description is required',
                'thumbnail-image.required'  => '(*) Thumbnail is required',
            ];

            $validator = Validator::make($request->all(), [
                'video-url' => 'required',
                'title' => 'required|string|max:100',
                'content' => 'required',
                'thumbnail-image' => 'required',
            ], $messages);

            if ($validator->fails()) {
                \Session::flash('msg', 'Video save unsuccessful!' );
                \Session::flash('status', 'fail' );
                 return redirect()->back()->withErrors($validator)->withInput();
            }

            $post_id = $request->input('post_id', 0);
            $language = $request->input('language', 'en');
            $video_url = $request->input('video-url');
            $title = $request->input('title');
            $duration = $request->input('duration', '00:00');
            $channel = $request->input("channel");
            // if (is_null($short_desc) || empty($short_desc)) $short_desc = '00:00';
            $content = $request->input('content');
            $thumbnail_image = $request->input('thumbnail-image');
            $thumbnail_image = Utils::str_replace_first(config('app.url'), '', $thumbnail_image);
            $exist_slug = false;

            if (is_numeric($post_id) && $post_id > 0) {
                $post = Post::find($post_id);
                $exist_slug = true;
                $arr_title = json_decode($post->title, true);
                $arr_content = json_decode($post->content, true);
                $arr_short_desc = (array) json_decode($post->short_desc, true);
            } else {
                $post = new Post();
                $arr_title = array();
                $arr_content = array();
                $arr_short_desc = array();
                $slug = Str::slug($title);
                $post->slug_url = $slug;
            }
            $arr_title[$language] = $title;
            $arr_content[$language] = $content;
            $arr_short_desc["duration"] = $duration;
            $arr_short_desc["channel"] = $channel;
            $post->post_type = Constants::POST_TYPE_POST;
            $post->post_format = Constants::POST_FORMAT_VIDEO;
            $post->video_url = $video_url;
            $post->title = json_encode($arr_title);
            $post->short_desc = json_encode($arr_short_desc);
            $post->content = json_encode($arr_content);
            $post->images = $thumbnail_image;
            $post->user_id = Auth::user()->id;
            $post->save();

            if (!$exist_slug) {
                $post->slug_url .= '-'.$post->id;
                $post->save();
            }

            /* seo of post */
            $this->save_seo_post($request, $post->id, $language);

            \Session::flash('msg', 'Video saved successful.' );
            \Session::flash('status', 'success' );
        } catch (Exception $e) {
            $validator = Validator::make([], []);
            $validator->getMessageBag()->add('unknown_exception', 'Error: ' . $e->getMessage());
            \Session::flash('msg', 'Video save unsuccessful!' );
            \Session::flash('status', 'fail' );
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return redirect('/content/video');
    }

    public function delete_video(Request $request) {

        try {
            Post::destroy($request->input('id', 0));
            \Session::flash('msg', 'Video deleted successful.' );
            \Session::flash('status', 'success' );
        } catch (Exception $e) {
            \Session::flash('msg', 'Video delete unsuccessful!' );
            \Session::flash('status', 'fail' );
        }

        return redirect('/content/video');
    }

    /*
     * Use Youtube API to get video info
     */
    public function get_video_info(Request $request) {
        $data = array();
        try {
            $video_url = $request->input('url');
            if (is_null($video_url) || empty($video_url)) {
                return 'url empty';
            }
            parse_str( parse_url( $video_url, PHP_URL_QUERY ), $my_array_of_vars );
            $video_id = $my_array_of_vars['v'];

            $youtube_v3_url = 'https://youtube.googleapis.com/youtube/v3/videos?part=snippet,contentDetails'
                . '&key=AIzaSyBcMDO-i86lI8Sz2DeADkm6-7ImIAqsvTk'
                . '&id=' . $video_id;


            $json_text = json_decode(NetworkUtils::fetch_content_from_url($youtube_v3_url));
            $items = $json_text->items;
            if (!is_null($items) && count($items) > 0) {
                $video = $items[0];
                $snippet = $video->snippet;
                $title = $snippet->title;
                $id_video = $video->id;
                $channel = $video->snippet->channelTitle;

                $description = str_replace("\n", "<br/>", $snippet->description);
                $thumbnail = $snippet->thumbnails->standard->url;

                $duration = $video->contentDetails->duration;
                $duration = Utils::str_replace_first('PT', '', $duration);
                $duration = Utils::str_replace_first('H', ':', $duration);
                $duration = Utils::str_replace_first('M', ':', $duration);
                $duration = Utils::str_replace_first('S', '', $duration);
                $data['id_video'] = $id_video;
                $data['status'] = 'success';
                $data['title'] = $title;
                $data['description'] = $description;
                $data['thumbnail'] = $thumbnail;
                $data['duration'] = $duration;
                $data['channel'] = $channel;

            }

        } catch (Exception $e) {
            $data['status'] = 'fail';
            $data['error'] = $e->getMessage();
        }
        return response()->json($data);
    }
}
