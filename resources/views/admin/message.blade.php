@extends('layouts.app')
@section('nav-message', 'active')
@section('content')
    <!-- Content Wrapper. Contains breadcrum -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1><a style="font-size: 24px; color: #555555; display: inline-block; margin-right: 15px;"
                        data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> Messages</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active"><strong>Messages</strong></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-body">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover ">
                                <thead>
                                    <tr style="text-align: center">
                                        <th width="50">#</th>
                                        <th width="250"  style="text-align:left">From</th>
                                        <th width="250" style="text-align:left">To</th>
                                        <th width="250" style="text-align:left">Content</th>
                                        <th width="200">Ngày gửi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($messages as $message)

                                    @php
                                    $array_receipent = json_decode($message->receipent, true);
                                    @endphp
                                        <tr style="text-align: center">
                                            <td>{{ $message->id }}</td>
                                            <td style="text-align:left">{{ $message->email }}</td>
                                            <td style="text-align:left">
                                                @foreach ($array_receipent as  $receipent)
                                                    <p>{{$receipent}}</p>
                                                @endforeach
                                            </td>
                                            <td style="text-align:left">
                                                <p id="content{{$message->id}}" style="  -webkit-line-clamp: 2;
                                                            /* -webkit-box-orient: vertical; */
                                                            overflow: hidden;
                                                            margin-bottom: 0;
                                                            display: -webkit-box;">{{ $message->content }}</p>
                                               <a class="check-content" data-id="{{$message->id}}" href="" onclick=" detail(event, {{$message->id}})" style="display:block; text-align:right"><i style="font-size:12px" class="fa fa-arrow-right"></i> Detail</a>
                                            </td>
                                            <td>{{$message->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @empty
                                </tr>
                                    <td colspan="5"><h3 style="text-align: center;">Empty data</h3></td>
                                </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{$messages->links()}}
            </div>
        </div>

        <script>
            function deleteGame(name) {
                if (confirm('Delete slide: ' + name + '?')) {
                    $('#delete-slider').submit();
                }
            }
            function detail(e, $messageId) {
                e.preventDefault();
                console.log($("#content"+$messageId).css("-webkit-box-orient"));
                if($("#content"+$messageId).css("-webkit-box-orient") == "vertical") {
                    e.target.innerHTML = "<i style='font-size:12px' class='fa fa-arrow-left'></i> Collapse";
                    $("#content"+$messageId).css("-webkit-box-orient", "unset");
                }
                else {
                    e.target.innerHTML = "<i style='font-size:12px' class='fa fa-arrow-right'></i> Detail";
                    $("#content"+$messageId).css("-webkit-box-orient", "vertical");
                }
            }
            $(".check-content").each(function(index, item) {
                var idMessage = item.getAttribute("data-id");
                var paragraphHeight = $("#content"+idMessage)[0].offsetHeight;
                var lines = paragraphHeight / 24;
                item.style.display = "none";
                if(lines > 2) {
                    $("#content"+idMessage).css("-webkit-box-orient", "vertical");
                    item.style.display = "block";
                }
            })
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
