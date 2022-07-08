<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
use App\Constants;
use App\Models\User;
use App\Models\Config;
use App\Models\Slider;
use App\Utils;
use Dflydev\DotAccessData\Util;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $model;
    public function __construct()
    {
        $this->model = Slider::query();
    }
    public function index() {
        $sliders = $this->model->orderBy("id", "desc")->get();
        $languages = Config::get_languages();
        return view('admin.slider')->with(compact('languages', 'sliders'));
    }
    public function save(Request $request) {
        $validator = Validator::make($request->all(), [
            'slider-title' => 'required|string|max:100',
        ],
        [
            'slider-title.required'  => '(*) Title is required',
        ]);
        if ($validator->fails()) {
            $messageError = [
                "msg"=> "Slider save unsuccessful!",
                "status"=>"fail"
            ];
             return redirect()->back()->with($messageError)->withErrors($validator)->withInput();
        }
        $arrayTitle = array();
        $arrayTitle[Constants::DEFAULT_LANGUAGE] = $request->input("slider-title");
        $this->model->create(["title"=>json_encode($arrayTitle)]);
        $messageSuccess = [
            "msg"=> "Slider save successful!",
            "status"=>"success"
        ];
        return back()->with($messageSuccess);
    }
    public function edit(Request $request,$idSlider) {
        $slider = $this->model->findOrFail($idSlider);
        //language
        $cfg_languages = Config::get_languages();
        $languages = [Constants::DEFAULT_LANGUAGE => Constants::DEFAULT_LANG_NAME];
        if (!is_null($cfg_languages) && count($cfg_languages) > 0) {
            foreach($cfg_languages as $lang_code) {
                $languages[$lang_code] = Constants::LANGUAGES[$lang_code];
            }
        }
        $selected_lang = $request->input('language', Constants::DEFAULT_LANGUAGE);
        return view("admin.slider-edit", compact("slider", "languages", "selected_lang"));
    }
    public function update(Request $request, $idSlider) {

        $validator = Validator::make($request->all(), [
            'slider-title' => 'required|string|max:100',
        ],
        [
            'slider-title.required'  => '(*) Title is required',
        ]);
        if ($validator->fails()) {
            $messageError = [
                "msg"=> "Slider save unsuccessful!",
                "status"=>"fail"
            ];
             return redirect()
             ->back()->with($messageError)->withErrors($validator)->withInput();
        }

        $slider = $this->model->find($idSlider);
        $dataTitle = json_decode($slider->title, true);
        $dataTitle[$request->language] = $request->input("slider-title");
        $slider->update([
            "title"=>json_encode($dataTitle),
            "images"=>str_replace(config('app.url'), '',$request->photo),
            "is_active"=>$request->is_active
        ]);
        $messageSuccess = [
            "msg"=> "Slider update successful!",
            "status"=>"success"
        ];
        return redirect()->route("slider.index")->with($messageSuccess);
    }
    public function delete($idSlider) {
        $slider = Slider::findOrFail($idSlider);
        Slider::destroy($idSlider);
        $messageSuccess = [
            "msg"=> "Slider delete successful!",
            "status"=>"success"
        ];
        return redirect()->route("slider.index")->with($messageSuccess);
    }


}
