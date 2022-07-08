<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Channel;
use App\Models\Config;
use App\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ChannelController extends Controller
{
    protected $model;
    public function __construct()
    {
        $this->model = Channel::query();
        $channels = $this->model->select("id", "title", "image", "link")->latest()->get();
        $languages = Config::get_languages();
        $languagesSelect = [Constants::DEFAULT_LANGUAGE => Constants::DEFAULT_LANG_NAME];
        if (!is_null($languages) && count($languages) > 0) {
            foreach($languages as $lang_code) {
                $languagesSelect[$lang_code] = Constants::LANGUAGES[$lang_code];
            }
        }
        View::share('channels', $channels);
        View::share('languages', $languages);
        View::share('languagesSelect', $languagesSelect);
    }
    public function index() {
        return view("admin.channel");
    }
    public function save(Request $request) {
        $validator = Validator::make($request->all(), [
            'channel-title' => 'required',
            'photo' => 'required',
            'channel-link' => 'required',
        ],
        [
            'channel-title.required'  => '(*) Title is required',
            'photo.required'  => '(*) Image is required',
            'channel-link.required'  => '(*) Link is required',
        ]);
        if ($validator->fails()) {
            $messageError = [
                "msg"=> "Channel save unsuccessful!",
                "status"=>"fail"
            ];
             return redirect()
             ->back()->with($messageError)->withErrors($validator)->withInput();
        }
        $language = $request->input('language', 'en');
        $arr_title = array();
        $title = $request->input("channel-title");
        $arr_title[$language] = $title;
        $image = Utils::str_replace_first(config('app.url'), '', $request->photo);
        $link = $request->input("channel-link");
        Channel::create(
            [
                "title"=> json_encode($arr_title),
                "image"=>$image,
                "link"=>$link
            ]);
        $messageSuccess = [
            "msg"=> "Channel save successful!",
            "status"=>"success"
        ];
        return redirect()->route("channel.index")->with($messageSuccess);
    }
    public function edit(Request $request, $idChannel) {
        $channel = $this->model->findOrFail($idChannel);
        $selected_lang = $request->input('language', Constants::DEFAULT_LANGUAGE);
        return view("admin.channel", compact("channel","selected_lang"));
    }
    public function update(Request $request, $idChannel) {
        $validator = Validator::make($request->all(), [
            'channel-title' => 'required',
            'photo' => 'required',
            'channel-link' => 'required',
        ],
        [
            'channel-title.required'  => '(*) Title is required',
            'photo.required'  => '(*) Image is required',
            'channel-link.required'  => '(*) Link is required',
        ]);
        if ($validator->fails()) {
            $messageError = [
                "msg"=> "Channel update unsuccessful!",
                "status"=>"fail"
            ];
             return redirect()
             ->back()->with($messageError)->withErrors($validator)->withInput();
        }

        $channel = $this->model->find($idChannel);
        $dataTitle = json_decode($channel->title, true);
        $dataTitle[$request->language] = $request->input("channel-title");
        $channel->update([
            "title"=>json_encode($dataTitle),
            "image"=>$request->photo,
            "link"=>$request->input("channel-link")
        ]);
        $messageSuccess = [
            "msg"=> "Channel update successful!",
            "status"=>"success"
        ];
        return redirect()->route("channel.index")->with($messageSuccess);
    }

    public function delete($channelId) {
        $channel = Channel::findOrFail($channelId);
        $channel->delete();
        $messageSuccess = [
            "msg"=> "Channel delete successful!",
            "status"=>"success"
        ];
        return redirect()->route("channel.index")->with($messageSuccess);
    }
}
