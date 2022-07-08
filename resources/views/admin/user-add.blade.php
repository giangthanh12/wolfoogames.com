@extends('layouts.app')
@section('nav-video','active')
@section('content')
<!-- Content Wrapper. Contains breadcrum -->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1><a style="font-size: 24px; color: #555555; display: inline-block; margin-right: 15px;" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> Video</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active"><strong>Video</strong></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Video list</h3>
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
                                <a type="button" class="btn btn-primary" href="/content/video/add">
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
                                <th width="50">STT</th>
                                <th width="200">Thumbnail</th>
                                <th style="text-align: left;">Title</th>
                                <th>Language</th>
                                <th width="100" style="text-align: left;">Last updated</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($video_list))
                            @foreach($video_list as $video)
                            @php
                                $title = json_decode($video->title, true);

                                $def_title = App\Utils::get_array_item_value('en', $title, '');
                                $def_title = str_replace("'","\'", $def_title);

                                $arr_lang = array();

                                if (is_array($title)) $arr_lang = array_keys($title);

                            @endphp
                            <tr style="text-align: center">
                                <td>1</td>
                                <td><img src="{{ $video->images }}" style="width: 100%" /></td>
                                <td style="text-align: left; max-width: 400px;">
                                    <div style="white-space: normal!important;">{{ array_key_exists('en', $title) ? $title['en'] : '' }}</div>
                                    <div class="mt-1" style="font-size: 15px; color: #999999"><i class="far fa-clock"></i> {{ $video->short_desc }}</div>
                                </td>
                                <td>
                                    @foreach($languages as $lang)
                                    <a href="/content/video/edit?id={{ $video->id }}&language={{ $lang }}" class="lang-edit">
                                    <span class="lang-{{ !is_null($arr_lang) && in_array($lang, $arr_lang) ? 'active' : 'unactive' }}">{{ $lang }}</span></a>
                                    @endforeach
                                </td>
                                <td style="font-size: 90%; text-align: left">
                                    <div>{{ $video->updated_at->format('d/m/Y H:i')}}</div>
                                    <div style="color: #888888">@php
                                    $poster = $video->poster;
                                    if (!is_null($poster)) {
                                        echo 'By ' . $poster->name;
                                    }
                                    @endphp</div>
                                </td>
                                <td>
                                    <a href="/content/video/edit?id={{ $video->id }}&language=en" class="btn btn-sm btn-primary"><i class="far fa-edit"></i> Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteVideo({{ $video->id }}, '{{ $def_title }}')"><i class="far fa-trash-alt"></i> Delete</button>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                @if(!is_null($video_list) && $video_list->lastPage() > 1)
				<div class="card-footer clearfix" style="padding-bottom: 0!important">
					{{ $video_list->withQueryString()->onEachSide(5)->links('pagination::bootstrap-5') }}
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

    function deleteVideo(id, name) {
        if (confirm('Delete video: ' + name + '?')) {
            location.href = "/content/video/delete?id=" + id;
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
