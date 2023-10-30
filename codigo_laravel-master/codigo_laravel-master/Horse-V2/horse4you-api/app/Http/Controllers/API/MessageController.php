<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use App\Events\SendMessage;
use Illuminate\Support\Facades\DB;

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
        $request->validate([
            'to' => 'required|integer',
            'content' => 'required|string'
        ]);
        $id = Auth::user()->id;
        if($id != $request->input('to')){
            $message = New Message();
            $message->to = $request->input('to'); /// $request->to;
            $message->content = $request->input('content');// $request->content;
            $message->from = $id;
            $message->save();
            broadcast(new SendMessage($message, $request->input('to')));
                    
            return response()->json([$message], 200);
        }else{
            return response()->json(["errors" => "O usuario não pode enviar mensagem para si mesmo"], 203);
        }
    }
    public function ultimaMensagem(){
        $id = Auth::user()->id;

        $userTos = Message::where('to',$id)->where('from','<>',$id)->groupBy('from')->orderBy('messages.from','DESC')->get();

        $userFroms = Message::where('from',$id)->where('to','<>',$id)->groupBy('to')->orderBy('messages.to','DESC')->get();
        
        $apagar = false;
        $mensagens = $userTos->merge($userFroms);
        $mensagensNew = $mensagens;
        foreach($mensagens as $keyex => $mensagem1){
            if($mensagem1['to'] == $id){
                $idMe = $mensagem1['from'];
            }else{
                $idMe = $mensagem1['to'];
            } 
            foreach($mensagens as $keyin => $mensagem2){
                if($keyex != $keyin){
                    if($idMe == $mensagem2['from'] || $idMe == $mensagem2['to']){
                        if($mensagem1['created_at'] < $mensagem2['created_at']){
                            $apagar = true;
                        }else{
                            unset($mensagensNew[$keyin]);
                        }
                    }
                }
            }
            if($apagar){
                $apagar = false;
                unset($mensagensNew[$keyex]);
            }
        }
        $mensagensNew =  $mensagensNew->reverse();;
    
        return response()->json($mensagensNew, 200);
    }
}

