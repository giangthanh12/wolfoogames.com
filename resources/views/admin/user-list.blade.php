@extends('layouts.app')
@section('nav-user-list','active')
@section('content')
<!-- Content Wrapper. Contains breadcrum -->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1><a style="font-size: 24px; color: #555555; display: inline-block; margin-right: 15px;" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> User</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">User</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User list</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-user-add" data-backdrop="static" data-keyboard="false">
                            <i class="fas fa-user-plus"></i> New user
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr style="text-align: center">
                                <th width="50"></th>
                                <th width="80">Avatar</th>
                                <th style="text-align: left;">Name</th>
                                <th>Email</th>
                                <th width="100" style="text-align: left;">Created date</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!is_null($user_list) && count($user_list) > 0)
                            @php
                                $logged_email = Auth::user()->email;
                            @endphp
                            @foreach($user_list as $user)
                            @php
                                $avatar = $user->profile_photo_path;
                                if (is_null($avatar) || empty($avatar)) {
                                    $avatar = '/dist/img/user2-160x160.jpg';
                                }
                            @endphp
                            <tr style="text-align: center">
                                <td>{{ $user->id }}</td>
                                <td><img src="{{ $avatar }}" style="width: 100%" class="img-circle elevation-1" /></td>
                                <td style="text-align: left; max-width: 400px;">
                                    {{ $user->name }}
                                </td>
                                <td>{{ $user->email }}</td>
                                <td style="font-size: 90%; text-align: left">
                                    <div>{{ $user->updated_at->format('d/m/Y H:i')}}</div>
                                </td>
                                <td>@if (!in_array($user->email, config('app.super_emails'))
                                        && $logged_email !== $user->email)
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-user-edit" data-backdrop="static" data-keyboard="false"
                                            data-name="{{ $user->name }}" data-email="{{ $user->email }}"><i class="far fa-edit"></i> Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')"><i class="far fa-trash-alt"></i> Delete</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="modal-user-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add new user</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Fullname</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter your name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="password_comfirmed">Confirm password</label>
                        <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm password">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-save">Save changes</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-user-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit user</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Fullname</label>
                        <input type="text" class="form-control" id="edit-name" placeholder="Enter your name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="hidden" class="form-control" id="edit-email" placeholder="Enter email">
                        <div id="display-email"></div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="edit-password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="password_comfirmed">Confirm password</label>
                        <input type="password" class="form-control" id="edit-password_confirmation" placeholder="Confirm password">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-update">Save changes</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    $(document).ready(function() {
        /* add new user modal */
        $('#modal-user-add').on('show.bs.modal', function (event) {
            var modal = $(this);
            modal.find('#name').val('');
            modal.find('#email').val('');
            modal.find('#password').val('');
            modal.find('#password_confirmation').val('');
        });

        $('#btn-save').on('click', function() {
            // add new user
            var modal = $('#modal-user-add');
            var name = modal.find('#name').val();
            var email = modal.find('#email').val();
            var password = modal.find('#password').val();
            var password_confirmation = modal.find('#password_confirmation').val();
            /* jquery post data	*/
            $.ajax({
                url: "/system/user/save-add",
                method: "POST",
                data: {
                    'name': name,
                    'email': email,
                    'password': password,
                    'password_confirmation': password_confirmation
                },
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function (jsResult) {
                    console.log(jsResult);
                    if (jsResult.status === 'success') {
                        toastr.success(jsResult.message);
                        modal.modal('hide');
                        location.href = '/system/user/list';
                    } else {
                        toastr.error(jsResult.message);
                    }
                }
            });
            /**/
        });

        /* edit user information modal */
        $('#modal-user-edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var name = button.data('name');
            var email = button.data('email');

            var modal = $(this);
            modal.find('#edit-name').val(name);
            modal.find('#edit-email').val(email);
            modal.find('#display-email').html(email);
            modal.find('#edit-password').val('');
            modal.find('#edit-password_confirmation').val('');
        });

        $('#btn-update').on('click', function() {
            // add new user
            var modal = $('#modal-user-edit');
            var name = modal.find('#edit-name').val();
            var email = modal.find('#edit-email').val();
            var password = modal.find('#edit-password').val();
            var password_confirmation = modal.find('#edit-password_confirmation').val();

            /* jquery post data	*/
            $.ajax({
                url: "/system/user/save-edit",
                method: "POST",
                data: {
                    'name': name,
                    'email': email,
                    'password': password,
                    'password_confirmation': password_confirmation
                },
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function (jsResult) {
                    console.log(jsResult);
                    if (jsResult.status === 'success') {
                        toastr.success(jsResult.message);
                        modal.modal('hide');
                        location.href = '/system/user/list';
                    } else {
                        toastr.error(jsResult.message);
                    }
                }
            });
            /**/
        });
    });

    function deleteUser(id, name) {
        if (confirm('Delete user: ' + name + '?')) {
            location.href = "/system/user/delete?id=" + id;
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
