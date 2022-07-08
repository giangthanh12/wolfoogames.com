@extends('layouts.app')
@section('nav-config','active')
@section('content')
<!-- Content Wrapper. Contains breadcrum -->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1><a style="font-size: 24px; color: #555555; display: inline-block; margin-right: 15px;" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> Config</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active"><strong>Config</strong></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <form method="post" action="/system/config/save-language">@csrf
                            <label>Language</label>
                            {!! Form::select('languages[]', App\Constants::LANGUAGES, $languages,
                                ['class' => 'select2', 'multiple'=>'multiple',
                                'data-placeholder'=>'Select a language', 'style'=>'width: 100%;']) !!}
                            <button type="submit" class="btn btn-primary mt-2" style="width: 120px"><i class="fas fa-save"></i>Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <form method="post" action="/system/config/save-email">
                            @csrf
                            <label>Emails</label>
                            {!! Form::select('emails[]', $array_emails, $selected_emails,
                                ['class' => 'select2', 'multiple'=>'multiple',
                                'data-placeholder'=>'Select a menu', 'style'=>'width: 100%;']) !!}
                            <button type="submit" class="btn btn-primary mt-2" style="width: 120px"><i class="fas fa-save"></i>Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        @php
        $contentAbout = is_null($contentAbout) ? "" : App\Utils::get_array_item_value($selected_lang, json_decode($contentAbout, true), '');
        @endphp
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <form method="post" action="{{route("config.save-about")}}"  style="width: 100%; display:block">
                                @csrf
                                    <label>About</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend"><span class="input-group-text">Language &nbsp;
                                            </span></div>
                                        {!! Form::select('language', $languagesSelect, $selected_lang, ['id' => 'language', 'class' => 'form-control']) !!}
                                    </div>
                                    <div class="input-group mb-3">
                                        <textarea required class="form-control" id="content" name="content" rows="15" placeholder="Description">{!! old('content', $contentAbout)!!}</textarea>
                                    <div class="input-group mb-3">
                                <button type="submit" class="btn btn-primary mt-2" style="width: 120px"><i class="fas fa-save"></i>Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
    $(document).ready(function() {
        //Initialize Select2 Elements
        $('.select2').select2();
    });
    </script>

  <script>
      $('#lfm').filemanager('image');
      $('#language').on('change', function() {
          location.href = '/system/config?language=' + $(this).val();
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




