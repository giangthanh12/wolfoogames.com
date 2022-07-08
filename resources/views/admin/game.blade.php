@extends('layouts.app')
@section('nav-game','active')
@section('content')
<!-- Content Wrapper. Contains breadcrum -->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1><a style="font-size: 24px; color: #555555; display: inline-block; margin-right: 15px;" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> Game</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active"><strong>Game</strong></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Game list</h3>
                    <div class="card-tools">
                        <form method="get" action="" id="frm-search">
                        <div class="input-group input-group-sm">
                            <input type="text" value="{{ $search }}" name="search" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="input-group-append" style="margin-left: 10px;">
                                <a type="button" class="btn btn-primary" href="/content/game/add">
                                    <i class="fas fa-plus"></i> Add new
                                </a>
                            </div>
                        </div>
                        <input type="hidden" id="page" name="page" value="{{ $page }}" />
                        </form>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr style="text-align: center">
                                <th width="50"></th>
                                <th width="60">Icon</th>
                                <th style="text-align: left">Title</th>
                                <th>Language</th>
                                <th width="100" style="text-align: left;">Last updated</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($game_list))
                            @php $idx = 1; @endphp
                            @foreach($game_list as $game)
                            @php
                                $title = json_decode($game->title, true);
                                $images = json_decode($game->images, true);
                                $package_id = json_decode($game->package_id, true);

                                $android_pkg    = App\Utils::get_array_item_value('android', $package_id, '');
                                $iphone_pkg     = App\Utils::get_array_item_value('iphone', $package_id, '');
                                $def_title = App\Utils::get_array_item_value('en', $title, '');
                                $def_title = str_replace("'","\'", $def_title);

                                $arr_lang = array();

                                if (is_array($title)) $arr_lang = array_keys($title);
                                if ($images == null) $images = array();

                            @endphp
                            <tr style="text-align: center">
                                <td>{{ $game->id }}</td>
                                <td>@if (array_key_exists('icon', $images)) <img src="{{ $images['icon'] }}" width="50" height="50" /> @endif</td>

                                <td style="text-align: left">
                                    <div class="mb-2"><strong>{{ array_key_exists('en', $title) ? $title['en'] : '' }}</strong></div>
                                    <div class="mb-2">
                                        @if (!empty($android_pkg))
                                        <a href="https://play.google.com/store/apps/details?id={{ $android_pkg }}" target="_blank">
                                            <img src="/images/android-flat.png" width="24" height="24" style="padding: 2px;" /></a>
                                        @endif
                                        @if (!empty($iphone_pkg))
                                        <a href="{{ $iphone_pkg }}" target="_blank">
                                            <img src="/images/apple-flat.webp" width="28" height="28" style="padding: 2px;" /></a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @foreach($languages as $lang)
                                    <a href="/content/game/edit?id={{ $game->id }}&language={{ $lang }}" class="lang-edit">
                                    <span class="lang-{{ !is_null($arr_lang) && in_array($lang, $arr_lang) ? 'active' : 'unactive' }}">{{ $lang }}</span></a>
                                    @endforeach
                                </td>
                                <td style="font-size: 90%; text-align: left">
                                    <div>{{ $game->updated_at->format('d/m/Y H:i')}}</div>
                                    <div style="color: #888888">@php
                                    $poster = $game->poster;
                                    if (!is_null($poster)) {
                                        echo 'By ' . $poster->name;
                                    }
                                    @endphp</div>
                                </td>
                                <td>
                                    <a href="/content/game/edit?id={{ $game->id }}&language=en" class="btn btn-sm btn-primary"><i class="far fa-edit"></i> Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteGame({{ $game->id }}, '{{ $def_title }}')"><i class="far fa-trash-alt"></i> Delete</button>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                @if(!is_null($game_list) && $game_list->lastPage() > 1)
				<div class="card-footer clearfix" style="padding-bottom: 0!important">
					{{ $game_list->withQueryString()->onEachSide(5)->links('pagination::bootstrap-5') }}
				</div>
				@endif
            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        $('#frm-search').on('submit', function() {
            $('#page').val(1);
        });
    });

    function deleteGame(id, name) {
        if (confirm('Delete game: ' + name + '?')) {
            location.href = "/content/game/delete?id=" + id;
        }
    }
</script>
@if(Session::has('msg'))
<script>
    @if (Session::get('status') === 'success')
    toastr.success('{!!Session::get('msg')!!}');
    @else
    toastr.error('{!!Session::get('msg')!!}');
    @endif
</script>
@endif

@endsection
