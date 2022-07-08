@extends('layouts.app')
@section('nav-slider', 'active')
@section('content')
    <!-- Content Wrapper. Contains breadcrum -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1><a style="font-size: 24px; color: #555555; display: inline-block; margin-right: 15px;"
                        data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> Slider</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"><strong>Slider</strong></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form class="form-coltrol" method="post" action="/content/slider/save"
                            enctype="multipart/form-data">@csrf
                            <div class="input-group mb-3" style="max-width: 500px!important">
                                <input type="text" placeholder="Slider title" class="form-control" id="slider-title"
                                    name="slider-title" value="{{ old('slider-title') }}" />
                                <span class="input-group-append">
                                    <button type="submit" style="width: 80px; text-align: center;"
                                        class="btn btn-primary">Create</button>
                                </span>
                            </div>
                            @error('slider-title')
                                <div class="text-danger" id="feature-error">{{ $errors->first('slider-title') }}</div>
                            @enderror
                        </form>


                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr style="text-align: center">
                                        <th width="50">#</th>
                                        <th>Name</th>
                                        <th>Language</th>
                                        <th>Số lượng slide</th>
                                        <th>Active</th>
                                        <th width="200">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sliders as $slider)
                                    @php
                                    $title = json_decode($slider->title, true);
                                    $def_title = App\Utils::get_array_item_value('en', $title, '');

                                    $def_title = str_replace("'","\'", $def_title);

                                    $arr_lang = array();

                                    if (is_array($title)) $arr_lang = array_keys($title);

                                    @endphp
                                        <tr style="text-align: center">
                                            <td>{{ $slider->id }}</td>
                                            <td>{{ array_key_exists('en', $title) ? $title['en'] : '' }}</td>
                                            <td>
                                                @foreach($languages as $lang)
                                                <a href="/content/slider/edit/{{ $slider->id }}?language={{ $lang }}" class="lang-edit">
                                                <span class="lang-{{ !is_null($arr_lang) && in_array($lang, $arr_lang) ? 'active' : 'unactive' }}">{{ $lang }}</span></a>
                                                @endforeach
                                            </td>
                                            <td>{{$slider->total_slide($slider->images)}}</td>
                                            <td>
                                                @if ($slider->is_active)
                                                <span class="badge badge-pill badge-success">Active</span>
                                                @else
                                                <span class="badge badge-pill badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('slider.edit', $slider->id) }}"
                                                    class="btn btn-sm btn-primary"><i class="far fa-edit"></i> Edit</a>
                                                <form id="delete-slider" method="post" class="d-inline"
                                                        action="{{ route('slider.delete', $slider->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button
                                                        onclick="deleteGame('{{ $slider->title }}')"
                                                        type="button" class="btn btn-sm btn-danger">
                                                        <i class="far fa-trash-alt"></i>Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function deleteGame(name) {
                if (confirm('Delete slide: ' + name + '?')) {
                    $('#delete-slider').submit();
                }
            }
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
