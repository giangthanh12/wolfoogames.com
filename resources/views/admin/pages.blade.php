@extends('layouts.app')
@section('nav-page', 'active')
@section('content')
    <!-- Content Wrapper. Contains breadcrum -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1><a style="font-size: 24px; color: #555555; display: inline-block; margin-right: 15px;"
                        data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> Pages</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"><strong>Pages</strong></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">News list</h3>
                        <div class="card-tools">
                            <form method="get" action="" id="frm-search">
                            <div class="input-group input-group-sm">
                                <div class="input-group-append" style="margin-left: 10px;">
                                    <a type="button" class="btn btn-primary" href="/content/page/add">
                                        <i class="fas fa-plus"></i> Add page
                                    </a>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                  <div class="card-body">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr style="text-align: center">
                                        <th width="50">#</th>
                                        <th>Name page</th>
                                        <th>Slug</th>
                                        <th>Languages</th>
                                        <th width="200">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pages as $page)
                                    @php
                                        $content = json_decode($page->content, true);
                                        $arr_lang = array();
                                        if (is_array($content)) $arr_lang = array_keys($content);
                                    @endphp
                                    <tr style="text-align: center">
                                        <td>{{ $page->id }}</td>
                                        <td>{{ $page->name }}</td>
                                        <td>{{ $page->slug }}</td>
                                        <td>
                                            @foreach($languages as $lang)
                                            <a href="/content/page/edit/{{ $page->id }}?language={{ $lang }}" class="lang-edit">
                                            <span class="lang-{{ !is_null($arr_lang) && in_array($lang, $arr_lang) ? 'active' : 'unactive' }}">{{ $lang }}</span></a>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('page.edit', $page->id) }}"
                                                class="btn btn-sm btn-primary"><i class="far fa-edit"></i> Edit</a>
                                            <form id="delete-slider" method="post" class="d-inline"
                                                    action="{{ route('page.delete', $page->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button
                                                    onclick="deleteGame('{{ $page->name }}')"
                                                    type="button" class="btn btn-sm btn-danger">
                                                    <i class="far fa-trash-alt"></i>Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                        </tr> <td colspan="5"><h3 style="text-align: center;">Empty data</h3></td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function deleteGame(name) {
                if (confirm('Delete page: ' + name + '?')) {
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
