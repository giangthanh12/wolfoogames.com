<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use Session;

use App\Models\Post;
use App\Models\PostSeo;
use App\Models\Config;
use App\NetworkUtils;
use App\Constants;
use App\Utils;

class PostController extends Controller {


    public function save_seo_post(Request $request, $post_id, $language) {
        /* seo of post */
        $seo_title = $request->input('seo-title', '');
        $seo_keyword = $request->input('seo-keyword', '');
        $seo_description = $request->input('seo-description', '');

        $post_seo = PostSeo::where('post_id', $post_id)->first();
        $arr_seo_title = array();
        $arr_seo_keyword = array();
        $arr_seo_description = array();
        if (is_null($post_seo)) {
            $post_seo = new PostSeo();
            $post_seo->post_id = $post_id;
        } else {
            $arr_seo_title = json_decode($post_seo->seo_title, true);
            $arr_seo_keyword = json_decode($post_seo->seo_keyword, true);
            $arr_seo_description = json_decode($post_seo->seo_description, true);
        }
        $arr_seo_title[$language] = $seo_title;
        $arr_seo_keyword[$language] = $seo_keyword;
        $arr_seo_description[$language] = $seo_description;

        $post_seo->seo_title = json_encode($arr_seo_title);
        $post_seo->seo_keyword = json_encode($arr_seo_keyword);
        $post_seo->seo_description = json_encode($arr_seo_description);
        $post_seo->save();
    }
}
