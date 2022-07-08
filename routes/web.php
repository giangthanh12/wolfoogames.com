<?php


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/********** Website Front-End *****/
Route::group(['namespace' => 'App\Http\Website'], function () {
    Route::get('/', 'HomeController@index')->name("home.index");
    Route::get('/games', 'GameController@index')->name("games.index");
    Route::get('/games/{slug}', 'GameController@detail')->name("games.detail");
    Route::get('game/install/{idGame}', 'GameController@install')->name("games.install");
    Route::get('/tips', 'TipsController@index')->name("tips.index");
    Route::get('/tips/{slug}', 'TipsController@detail')->name("tips.detail");
    Route::get('/videos', 'VideosController@index')->name("videos.index");
    Route::get('/videos/{slug}', 'VideosController@detail')->name("videos.detail");
    Route::get('/character', 'CharacterController@index')->name("character.index");
    Route::get('/character/{slug}', 'CharacterController@detail')->name("character.detail");
    Route::get('/about', 'AboutController@index')->name("about.index");
    Route::get('/change-language/{language}', 'HomeController@changeLanguage')->name("home.change-language");

    // send message
    Route::post('send-message', 'HomeController@sendMessage')->name("send-message");
});

/********** Website Back-End *****/
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::group(['namespace' => 'App\Http\Controllers'], function () {
        Route::get('/dashboard', 'DashboardController@index');

        Route::get('/content/game', 'GameController@index');
        Route::get('/content/game/add', 'GameController@show_add_form');
        Route::get('/content/game/edit', 'GameController@show_edit_form');
        Route::match(['post', 'get'], '/content/game/save', 'GameController@save');
        Route::get('/content/game/delete', 'GameController@delete_game');
        Route::get('/game/get-play-info', 'GameController@get_play_info');

        Route::get('/content/charactor', 'CharactorController@index');
        Route::get('/content/charactor/add', 'CharactorController@show_add_form');
        Route::get('/content/charactor/edit', 'CharactorController@show_edit_form');
        Route::match(['post', 'get'], '/content/charactor/save', 'CharactorController@save');
        Route::get('/content/charactor/delete', 'CharactorController@delete_charactor');

        Route::get('/content/video', 'VideoController@index');
        Route::get('/content/video/add', 'VideoController@show_add_form');
        Route::get('/content/video/edit', 'VideoController@show_edit_form');
        Route::match(['post', 'get'], '/content/video/save', 'VideoController@save');
        Route::get('/content/video/delete', 'VideoController@delete_video');
        Route::get('/content/video/get-video-info', 'VideoController@get_video_info');

        Route::get('/content/news', 'NewsController@index');
        Route::get('/content/news/add', 'NewsController@show_add_form');
        Route::get('/content/news/edit', 'NewsController@show_edit_form');
        Route::match(['post', 'get'], '/content/news/save', 'NewsController@save');
        Route::get('/content/news/delete', 'NewsController@delete_news');

        Route::get('/content/slider', 'SliderController@index')->name("slider.index");
        Route::post('/content/slider/save', 'SliderController@save');
        Route::get('/content/slider/edit/{sliderId}', 'SliderController@edit')->name("slider.edit");
        Route::post('/content/slider/update/{sliderId}', 'SliderController@update')->name("slider.update");
        Route::delete('/content/slider/delete/{sliderId}', 'SliderController@delete')->name("slider.delete");

        Route::get('/content/channel', 'ChannelController@index')->name("channel.index");
        Route::POST('/content/channel/save', 'ChannelController@save')->name("channel.save");
        Route::get('/content/channel/edit/{channelId}', 'ChannelController@edit')->name("channel.edit");
        Route::POST('/content/channel/update/{channelId}', 'ChannelController@update')->name("channel.update");
        Route::delete('/content/channel/delete/{channelId}', 'ChannelController@delete')->name("channel.delete");

        Route::get('/content/message', 'MessageController@index')->name("message.index");

        Route::get('/system/user/list', 'UserController@list');
        Route::match(['post', 'get'], '/system/user/save-add', 'UserController@save_add');
        Route::match(['post', 'get'], '/system/user/save-edit', 'UserController@save_edit');
        Route::get('/system/user/delete', 'UserController@delete_user');
        Route::get('/system/user/profile', 'UserController@profile');

        Route::get('/content/page', 'PageController@index')->name("page.index");
        Route::get('/content/page/add', 'PageController@add')->name("page.add");
        Route::post('/content/page/save', 'PageController@save')->name("page.save");
        Route::get('/content/page/edit/{pageId}', 'PageController@edit')->name("page.edit");
        Route::post('/content/page/update/{pageId}', 'PageController@update')->name("page.update");
        Route::delete('/content/page/delete/{pageId}', 'PageController@delete')->name("page.delete");



        Route::get('/system/config', 'ConfigController@index');
        Route::match(['post', 'get'], '/system/config/save-language', 'ConfigController@save_language');
        Route::post('/system/config/save-about', 'ConfigController@save_about')->name("config.save-about");
        Route::post('/system/config/save-email', 'ConfigController@save_email')->name("config.save-email");
        //config channel
        // Route::post( '/system/config/save-language', 'ConfigController@save_language');

        Route::post('/ckeditor/image_upload', 'CKEditorController@upload')->name('upload');
    });

});
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::controller(GoogleController::class)->group(function(){
        Route::get('/auth/google', 'redirectToGoogle')->name('auth.google');
        Route::get('/auth/google/callback', 'handleGoogleCallback');
    });

});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
