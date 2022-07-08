<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index() {
        $messages = Message::select("id", "name", "email","content","receipent", "created_at")->latest()->paginate(5);
        return view("admin.message", compact("messages"));
    }
}
