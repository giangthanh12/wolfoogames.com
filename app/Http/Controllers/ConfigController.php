<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
use App\Constants;
use App\Models\User;
use App\Models\Config;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(Request $request) {

        $languages = Config::get_languages();
        $languagesSelect = [Constants::DEFAULT_LANGUAGE => Constants::DEFAULT_LANG_NAME];
        if (!is_null($languages) && count($languages) > 0) {
            foreach($languages as $lang_code) {
                $languagesSelect[$lang_code] = Constants::LANGUAGES[$lang_code];
            }
        }
        $selected_lang = $request->input('language', Constants::DEFAULT_LANGUAGE);
        $contentAbout = Config::get_content();
        $emails = User::where("email", "<>", env('MAIL_FROM_ADDRESS', ''))->pluck("email")->toArray();
        $array_emails = array_combine($emails, $emails);
        $selected_emails = Config::get_emails();
        return view('admin.config')->with(compact('languages', 'selected_lang', 'languagesSelect', 'contentAbout', 'array_emails', 'selected_emails'));
    }

    public function save_language(Request $request) {
        if (strtoupper($request->method()) !== 'POST') return 'invalid';
        $languages = $request->input('languages');
        if (is_null($languages) || !in_array(Constants::DEFAULT_LANGUAGE, $languages)) {
            $languages[] = Constants::DEFAULT_LANGUAGE;
        }

        $str_lang = implode(';', $languages);

        $matchThese = ['cfg_key'=>'languages'];
        Config::updateOrCreate($matchThese, ['cfg_value'=>$str_lang]);
        return redirect('/system/config');
    }


    public function save_about(Request $request) {
        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ],
        [
            'content.required'  => '(*) Content is required',
        ]);
        if ($validator->fails()) {
            $messageError = [
                "msg"=> "Config about save unsuccessful!",
                "status"=>"fail"
            ];
             return redirect()
             ->back()->with($messageError)->withErrors($validator)->withInput();
        }
        $arr_content = array();
        $config_about = Config::find("about");

        if(!is_null($config_about)) {
            $arr_content = (array) json_decode($config_about->cfg_value);
        }

        $language = $request->input('language', 'en');
        $content = $request->content;
        $arr_content[$language] = $content;
        Config::updateOrCreate(  [
            'cfg_key' => 'about',
        ], ['cfg_value'=>json_encode($arr_content)]);

        $messageSuccess = [
            "msg"=> "Config about save successful!",
            "status"=>"success"
        ];
        return redirect()->back()->with($messageSuccess);
    }
    public function save_email(Request $request) {
        $validator = Validator::make($request->all(), [
            'emails' => "required|array",
        ],
        [
            'emails.required'  => '(*) Emails is array',
            'emails.array'  => '(*) Emails is array',
        ]);
        if ($validator->fails()) {
            $messageError = [
                "msg"=> "Config about save unsuccessful!",
                "status"=>"fail"
            ];
             return redirect()
             ->back()->with($messageError)->withErrors($validator)->withInput();
        }
        $arr_emails = $request->input('emails', []);
        Config::updateOrCreate(  [
            'cfg_key' => 'emails',
        ], ['cfg_value'=>json_encode($arr_emails)]);
        $messageSuccess = [
            "msg"=> "Config emails save successful!",
            "status"=>"success"
        ];
        return redirect()->back()->with($messageSuccess);
    }

}
