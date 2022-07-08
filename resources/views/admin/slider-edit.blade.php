@extends('layouts.app')
@section('nav-slider', 'active')
@section('content')
    <!-- Content Wrapper. Contains breadcrum -->
    @php
    $title = App\Utils::get_array_item_value($selected_lang, json_decode($slider->title, true), '');
    @endphp
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1><a style="font-size: 24px; color: #555555; display: inline-block; margin-right: 15px;"
                        data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> Edit post</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="/content/slider">Slider</a></li>
                    <li class="breadcrumb-item active"><strong>Edit Slider</strong></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form class="form-coltrol" method="post" action="{{ route('slider.update', $slider->id) }}"
                    enctype="multipart/form-data">@csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-9 col-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend"><span class="input-group-text">Language &nbsp;
                                            </span></div>
                                        {!! Form::select('language', $languages, $selected_lang, ['id' => 'language', 'class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="exampleInputEmail1">Tiêu đề slider</label>
                                        <input required type="text" class="form-control" id="slider-title"
                                            name="slider-title" placeholder="Slider title"
                                            value="{{ old('slider-title', $title) }}" />
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="inputPhoto" class="col-form-label">Images <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group  mb-3">
                                            <span class="input-group-btn">
                                                <a id="lfm" data-input="thumbnail" data-preview="holder"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="thumbnail" class="form-control" type="text" name="photo"
                                                value="{{ old('photo', $slider->images) }}" >
                                        </div>
                                        <div id="holder" style="margin-top:15px;max-height:100px;">
                                            @if (!is_null($slider->images))
                                                @foreach (explode(',', $slider->images) as $image)
                                                    <img src="{{ $image }}" style="height: 5rem;" alt="">
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="is_active" class="col-form-label">Status <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" name="is_active">
                                            <option @if ($slider->is_active == 1) selected @endif value="1">Active
                                            </option>
                                            <option @if ($slider->is_active == 0) selected @endif value="0">
                                                Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">

                                <button type="submit" class="btn btn-primary" style="width: 120px;"><i
                                        class="fas fa-save"></i> Save</button>
                            </div>
                </form>
            </div>
        </div>

        <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script>
            $('#lfm').filemanager('image');
            $('#language').on('change', function() {
                location.href = '/content/slider/edit/{{ $slider->id }}?language=' + $(this).val();
            });
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
