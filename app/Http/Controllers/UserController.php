<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
use DB;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function profile() {
        return view('admin.profile');
    }
    public function list() {
        $user_list = User::orderBy('name', 'asc')->get();
        return view('admin.user-list')->with(compact('user_list'));
    }

    public function save_add(Request $request) {
        if (strtoupper($request->method()) !== 'POST') return 'invalid';
        $data = array();
        $data['status'] = 'fail';
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3|max:50'
            ]);
            if ($validator->fails()) {
                $data['message'] = 'Your name is too short or too long';
                return response()->json($data);
            }

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users'
            ]);
            if ($validator->fails()) {
                $data['message'] = 'This email already exists or invalid';
                return response()->json($data);
            }

            $validator = Validator::make($request->all(), [
                'password' => 'required|confirmed|min:6|max:20'
            ]);
            if ($validator->fails()) {
                $data['message'] = 'Password invalid';
                return response()->json($data);
            }

            $name = $request->input('name', '');
            $email = $request->input('email', '');
            $password = $request->input('password', '');

            $newUser = User::updateOrCreate(['email' => $email],[
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password)
            ]);
            $data['status'] = 'success';
            \Session::flash('status', 'success' );
            \Session::flash('msg', 'New user created!' );
        } catch (Exception $e) {
            $data['message'] = 'Error: ' . $e->getMessage();
        }
        return response()->json($data);
    }

    public function save_edit(Request $request) {
        if (strtoupper($request->method()) !== 'POST') return 'invalid';
        $data = array();
        $data['status'] = 'fail';
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3|max:50'
            ]);
            if ($validator->fails()) {
                $data['message'] = 'Your name is too short or too long';
                return response()->json($data);
            }

            $validator = Validator::make($request->all(), [
                'email' => 'required|email'
            ]);
            if ($validator->fails()) {
                $data['message'] = 'This email is invalid';
                return response()->json($data);
            }
            $name = $request->input('name', '');
            $email = $request->input('email', '');

            $password = $request->input('password', '');
            $password_confirmation = $request->input('password_confirmation', '');


            if ((!is_null($password) && !empty($password))
                || (!is_null($password_confirmation) && !empty($password_confirmation))) {
                $validator = Validator::make($request->all(), [
                    'password' => 'required|confirmed|min:6|max:20'
                ]);
                if ($validator->fails()) {
                    $data['message'] = 'Password invalid';
                    return response()->json($data);
                }
                DB::table('users')->where('email', $email)->update(['name' => $name, 'password' => bcrypt($password)]);
            } else {
                DB::table('users')->where('email', $email)->update(['name' => $name]);
            }

            $data['status'] = 'success';
            \Session::flash('status', 'success' );
            \Session::flash('msg', 'User updated!' );
        } catch (Exception $e) {
            $data['message'] = 'Error: ' . $e->getMessage();
        }
        return response()->json($data);
    }

    public function delete_user(Request $request) {

        try {
            User::destroy($request->input('id', 0));
            \Session::flash('msg', 'User deleted successful.' );
            \Session::flash('status', 'success' );
        } catch (Exception $e) {
            \Session::flash('msg', 'User delete unsuccessful!' );
            \Session::flash('status', 'fail' );
        }

        return redirect('/system/user/list');
    }
}
