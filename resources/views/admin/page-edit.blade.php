@extends('layouts.app')
@section('nav-page', 'active')
@section('content')
    <!-- Content Wrapper. Contains breadcrum -->
    @php
    $content = App\Utils::get_array_item_value($selected_lang, json_decode($page->content, true), '');
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
                <form class="form-coltrol" method="post" action="{{ route('page.update', $page->id) }}"
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
                                    <div class="text-danger">{{ $errors->first('content') }}</div>
                                    <div class="form-group mb-3">
                                        <label for="name">Name page</label>
                                        <input required type="text" class="form-control" id="name"
                                            name="name" placeholder="Page title"
                                            value="{{ old('name', $page->name) }}" />
                                    </div>

                                    <div class="text-danger">{{ $errors->first('content') }}</div>
                                    <div class="input-group mb-3">
                                        <textarea required class="form-control" id="content" name="content" rows="15" placeholder="Description">{!! old('content', $content)!!}</textarea>
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
                location.href = '/content/page/edit/{{ $page->id }}?language=' + $(this).val();
            });
            var options = {
                width: "100%", height: "640px",
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                //filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                //filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
            };

            CKEDITOR.replace('content', options);
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
