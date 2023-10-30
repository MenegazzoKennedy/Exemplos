<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Message;
use App\Events\Chat\SendMessage;
use Illuminate\Support\Facades\Event;
use Auth;

class MessageController extends Controller
{
    public function listMessages(User $user){
        $userFrom = Auth::user()->id;
        $userTo = $user->id;
        
        $message = Message::where(
            function ($query) use ($userFrom, $userTo){
                $query->where([
                    'from' => $userFrom,
                    'to' =>$userTo
                ]);
            }
        )->orWhere(
            function ($query) use ($userFrom, $userTo){
                $query->where([
                    'from' => $userTo,
                    'to' =>$userFrom
                ]);
            }
        )->orderBy('created_at', 'ASC')->get();

        return response()->json([$message], 200);
    }
    public function store(Request $request){
        $message = New Message();
        $message->to = $request->to;
        $message->content = $request->content;
        $message->from = Auth::user()->id;
        $message->save();

        Event::dispatch(new SendMessage($message, $request->to));
    }
}
