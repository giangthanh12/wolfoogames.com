<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Config;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class PageController extends Controller
{
    protected $languages;
    public function __construct()
    {
        $this->languages = Config::get_languages();
        $this->model = Page::query();

    }
    public function index() {
        $pages = $this->model->select("id", "name", "content","slug")->latest()->get();
        $languages = $this->languages;
       return view("admin.pages", compact("pages", "languages"));
    }
    public function add(Request $request) {
        $languages = $this->languages;
        $languagesSelect = [Constants::DEFAULT_LANGUAGE => Constants::DEFAULT_LANG_NAME];
        if (!is_null($languages) && count($languages) > 0) {
            foreach($languages as $lang_code) {
                $languagesSelect[$lang_code] = Constants::LANGUAGES[$lang_code];
            }
        }
        $selected_lang = $request->input("language", Constants::DEFAULT_LANGUAGE);
        return view("admin.page-add", compact("languagesSelect", "selected_lang"));
    }
    public function save(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'content' => 'required',
        ],
        [
            'name.required'  => '(*) Name page is required',
            'content.required'  => '(*) Content page is required',
        ]);
        if ($validator->fails()) {
            $messageError = [
                "msg"=> "Page is exist!!",
                "status"=>"fail"
            ];
             return redirect()
             ->back()->with($messageError);
        }
        $language = $request->input('language', 'en');
        $name = $request->input("name");
        if(!Page::checkSlug(Str::slug(strtolower($name)))) {
            $messageError = [
                "msg"=> "Page  is exist!",
                "status"=>"fail"
            ];
             return redirect()
             ->back()->with($messageError)->withInput();
        }

        $arr_content = array();
        $content = $request->input("content");
        $arr_content[$language] = $content;
        Page::create(
            [
                "name"=>  $name,
                "slug"=>Str::slug($name),
                "content"=>json_encode($arr_content, true),
            ]);
        $messageSuccess = [
            "msg"=> "Page save successful!",
            "status"=>"success"
        ];
        return redirect()->route("page.index")->with($messageSuccess);
    }
    public function edit(Request $request, $idPage) {
        $page = $this->model->findOrFail($idPage);
        //language
        $cfg_languages = Config::get_languages();
        $languages = [Constants::DEFAULT_LANGUAGE => Constants::DEFAULT_LANG_NAME];
        if (!is_null($cfg_languages) && count($cfg_languages) > 0) {
            foreach($cfg_languages as $lang_code) {
                $languages[$lang_code] = Constants::LANGUAGES[$lang_code];
            }
        }
        $selected_lang = $request->input('language', Constants::DEFAULT_LANGUAGE);
        return view("admin.page-edit", compact("page", "languages", "selected_lang"));
    }
    public function update(Request $request, $idPage) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'content' => 'required',
        ],
        [
            'name.required'  => '(*) Name page is required',
            'content.required'  => '(*) Content page is required',
        ]);
        if ($validator->fails()) {
            $messageError = [
                "msg"=> "Page save unsuccessful!",
                "status"=>"fail"
            ];
             return redirect()
             ->back()->with($messageError)->withErrors($validator)->withInput();
        }

        $page = $this->model->find($idPage);
        $arr_content = json_decode($page->content, true);
        $arr_content[$request->language] = $request->input("content");
        $page->update([
            "name"=>$request->name,
            "content"=>json_encode($arr_content),
        ]);
        $messageSuccess = [
            "msg"=> "Page update successful!",
            "status"=>"success"
        ];
        return redirect()->route("page.index")->with($messageSuccess);
    }
    public function delete($pageId) {
        $page = Page::findOrFail($pageId);
        Page::destroy($pageId);
        $messageSuccess = [
            "msg"=> "Page delete successful!",
            "status"=>"success"
        ];
        return redirect()->route("page.index")->with($messageSuccess);
    }
}
