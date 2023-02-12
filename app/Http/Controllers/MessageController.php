<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StoreMessageRequest;
// use App\Http\Requests\UpdateMessageRequest;
use Illuminate\Http\Request;

use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{

  public function __construct(){
        $this->middleware('auth');
  }

  public function userlist(){
    $users = User::latest()->where('id','!=',auth()->user()->id)->get();
    
    if(\Request::ajax()){
      return response()->json($users,200);
    }
    return abort(404);
    
  }

  public function usermessage($id=null){

    if(!\Request::ajax()){
      return abort(404);
    }

    $user =  User::findOrFail($id);
    $messages = Message::where(function($q) use ($id){
      $q->where('from',auth()->user()->id);
      $q->where('to',$id);
    })->orWhere(function($q) use ($id){
      $q->where('from',$id);
      $q->where('to',auth()->user()->id);
    })->with('user')->get();

    return response()->json([
      'messages'=>$messages,
      'user'=> $user
    ]);
  }

  public function sendmessage(Request $request){

    if(!\Request::ajax()){
      return abort(404);
    }
    
    $messages = Message::create([
      'message'=> $request->message,
      'from'=>auth()->user()->id,
      'to'=>$request->user_id,
      'type'=>0
    ]);

    $messages = Message::create([
      'message'=> $request->message,
      'from'=>auth()->user()->id,
      'to'=>$request->user_id,
      'type'=>1
    ]);

    return response()->json($messages,201);
  }

}
