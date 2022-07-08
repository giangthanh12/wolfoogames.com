<?php

namespace App\Http\Website;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Utils;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    public function index(Request $request) {
      $videos = Post::select("id","slug_url", "video_url", "title","images", "short_desc", "updated_at")->where("post_format", "video")->paginate(12);
      foreach($videos as $video) {
        $video->video_url = explode("?v=", $video->video_url);
        $video->video_url = str_replace('"}', "",  $video->video_url[1]);
        }
        $last_page = $videos->lastPage();
        $dataVideos = "";
        if ($request->ajax()) {
            foreach($videos as $video) {
                $title = json_decode($video->title, true);
                $title = Utils::get_value_language($title);
                $link_detail_video = route("videos.detail", $video->slug_url);
                $dataVideos .= "<div class='grid_col grid_col_4 video-item-col'>
                     <div class='ce clearfix'>
                       <div>
                        <!-- gallery item -->
                        <div class='video-item'>
                            <div class='gallery-icon landscape'>
                                <iframe width='560' style='aspect-ratio: 2/1;width: 100%;' src='https://www.youtube.com/embed/$video->video_url' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
                            </div>
                            <div style=' display: block;
                            text-align: center;'
                             class='cws_fa_tbl_cell' >
                            <a href='$link_detail_video'><h2 style='height: 3em;
                                line-height: 1.5em;
                                overflow: hidden;
                                font-size: 20px;
                            '>$title</h2></a>
                            </div>
                        </div>
                </div>
            </div>
        </div>";
            }
            return  $dataVideos;
        }

      return view("client.videos", compact("videos","last_page"));
    }
    public function detail(Request $request, $slug) {
        $video = Post::select("id","slug_url", "video_url","content", "title","images", "short_desc", "updated_at")->where("slug_url", $slug)->first();
        if(is_null($video)) {
            return view("errors.404");
        }
        $video->video_url = explode("?v=", $video->video_url);

        $video->video_url = str_replace('"}', "",  $video->video_url[1]);

        $videos_related =  Post::select("id","slug_url", "video_url", "title","images", "content", "short_desc", "updated_at")
        ->where("post_format", "video")
        ->where("id", "<>", $video->id)
        ->latest()->paginate(6);
        foreach($videos_related as $video_related) {
            $video_related->video_url = explode("?v=", $video_related->video_url);
            $video_related->video_url = str_replace('"}', "",  $video_related->video_url[1]);
        }

        $last_page = $videos_related->lastPage();

        if ($request->ajax()) {
            $data_videos = "";
            foreach($videos_related as $video_related) {
                $title_video_related = json_decode($video_related->title, true);
                $title = array_key_exists('en', $title_video_related) ? $title_video_related['en'] : '';
                $link_detail_video = route("videos.detail", $video_related->slug_url);
                $channel = $video_related->get_channel();
            $data_videos .= "
            <div class='post_item' >
                <div class='post_preview clearfix'
                    style='display: flex;
                          flex-direction: row;
                          gap: 10px;'>
                   <div class='pic-item' style='width: 168px;height: 94px; flex:none'>
                        <img style='height: 100%;
                                    width: 100%;
                                    object-fit: cover;' src='$video_related->images' alt=''>
                   </div>
                    <div class='post_title'><a
                        style='font-size: 18px;
                        font-weight: 700;
                        -webkit-line-clamp: 2;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        display: -webkit-box;'
                        href='$link_detail_video'>$title</a>
                        <p class='title-channel' style='font-size: 14px; margin-bottom:0px;'>Channel: $channel</p>
                        <a href='$link_detail_video' style='font-size: 14px;'><i class='delimiter fa fa-chevron-right' style='font-size: 11px;'></i> Watch now</a>
                    </div>
                </div>
            </div>
          ";
            }
            return  $data_videos;
        }


        return view("client.detail-video", compact("video", "videos_related", "last_page"));
    }
}

