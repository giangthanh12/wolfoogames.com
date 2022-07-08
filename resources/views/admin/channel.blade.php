@extends('layouts.app')
@section('nav-channel', 'active')
@section('content')
    <!-- Content Wrapper. Contains breadcrum -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1><a style="font-size: 24px; color: #555555; display: inline-block; margin-right: 15px;"
                        data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> Channel</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"><strong>Channel</strong></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if (!isset($channel))
                    @else
                        @php
                        $title  = App\Utils::get_array_item_value($selected_lang, json_decode($channel->title, true), '');
                    @endphp
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <form method="post" action="{{isset($channel) ? route("channel.update", $channel->id) : route("channel.save")}}" enctype="multipart/form-data">
                                    @csrf
                                    <label>{{isset($channel) ? "Update channel with id = ".$channel->id : "Add channel"}}</label>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend"><span class="input-group-text">Language &nbsp;
                                                </span></div>
                                            {!! Form::select('language', $languagesSelect, isset($channel) ? $selected_lang : "en", ['id' => 'language', 'class' => 'form-control']) !!}
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="exampleInputEmail1">Title channel</label>
                                            <input required type="text" class="form-control" id="channel-title"
                                                name="channel-title" placeholder="Channel title"
                                                value="{{ old('channel-title', isset($channel) ? $title : "") }}" />
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="inputPhoto" class="col-form-label">Image<span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group  mb-3">
                                                <span class="input-group-btn">
                                                    <a id="lfm" data-input="thumbnail" data-preview="holder"
                                                        class="btn btn-primary">
                                                        <i class="fa fa-picture-o"></i> Choose
                                                    </a>
                                                </span>
                                                <input id="thumbnail" class="form-control" type="text" name="photo"
                                                    value="{{ old('photo',isset($channel) ? $channel->image : "") }}" >
                                            </div>
                                            <div id="holder" style="margin-top:15px;max-height:100px;">
                                                @if (isset($channel))
                                                    <img src="{{ asset($channel->image) }}" style="height: 5rem;" alt="">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="exampleInputEmail1">Link channel</label>
                                            <input required type="text" class="form-control" id="channel-link"
                                                name="channel-link" placeholder="Channel link"
                                                value="{{ old('channel-link',isset($channel) ? $channel->link : "") }}" />
                                        </div>
                                    <button type="submit" class="btn btn-primary mt-2" style="width: 120px; float: right;"><i class="fas fa-save"></i> Save</button>
                                </form>
                            </div>
                            <div class="col-8">
                                <label>List channels</label>
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr style="text-align: center">
                                            <th width="50"></th>
                                            <th style="text-align: left;">Title</th>
                                            <th style="text-align: left;">Image</th>
                                            <th>Language</th>
                                            <th width="100">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($channels as $item)
                                        @php
                                        $title = json_decode($item->title, true);

                                        $def_title = App\Utils::get_array_item_value('en', $title, '');
                                        $def_title = str_replace("'","\'", $def_title);
                                        $arr_lang = array();
                                        if (is_array($title)) $arr_lang = array_keys($title);
                                            @endphp
                                        <tr style="text-align: center">
                                            <td>{{ $item->id }}</td>
                                            <td style="text-align: left; max-width: 400px;">
                                                <div style="white-space: normal!important;">{{ array_key_exists('en', $title) ? $title['en'] : '' }}</div>
                                            </td>
                                            <td style="text-align: left;"><img src="{{ asset($item->image) }}" style="width: 50px; height:50px" /></td>

                                            <td>
                                                @foreach($languages as $lang)
                                                <a href="{{route("channel.edit", $item->id)}}?language={{ $lang }}" class="lang-edit">
                                                <span class="lang-{{ !is_null($arr_lang) && in_array($lang, $arr_lang) ? 'active' : 'unactive' }}">{{ $lang }}</span></a>
                                                @endforeach
                                            </td>

                                            <td>
                                                <a href="{{route("channel.edit",$item->id)}}?language=en" class="btn btn-sm btn-primary"><i class="far fa-edit"></i> Edit</a>
                                                <form id="delete-channel" method="post" class="d-inline"
                                                action="{{ route("channel.delete", $item->id) }}">
                                                @csrf
                                                @method('delete')
                                                <button
                                                onclick="deleteChannel('{{ array_key_exists('en', $title) ? $title['en'] : '' }}')"
                                                type="button" class="btn btn-sm btn-danger">
                                                <i class="far fa-trash-alt"></i>Delete</button>
                                        </form>
                                            </td>
                                        </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script>
            function deleteChannel(name) {
                if (confirm('Delete channel: ' + name + '?')) {
                    $('#delete-channel').submit();
                }
            }
        </script>




        <script>
            $('#lfm').filemanager('image');
            @if (isset($channel))
            $('#language').on('change', function() {
                location.href =" {{route("channel.edit", $channel->id)}} " + '?language=' + $(this).val();
            });
            @endif
        </script>

        @if (Session::has('msg'))
            <script>
                @if (Session::get('status') === 'success')
                    toastr.success('{!! Session::get('msg') !!}');
                @else
                    toastr.error('{!! Session::get('msg') !!}');
                @endif
            </script>
        @endif
    </div>
@endsection
