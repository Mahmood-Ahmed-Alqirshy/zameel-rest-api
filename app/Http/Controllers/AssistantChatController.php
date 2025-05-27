<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssistantChatRequest;
use App\Jobs\SendMessageToAI;
use App\Models\AssistantChat;
use Illuminate\Http\Request;

class AssistantChatController extends Controller
{
    public function store(Request $request)
    {
        $systemMessage = 'انت ذكاء اصطناعي لطبيق طلاب جامعات اسمه زميل وستقوم بمساعدة الطلاب في دراستهم';
        $messages = [
            ['role' => 'system', 'content' => $systemMessage],
        ];
        $chat = AssistantChat::create(['messages' => json_encode($messages)]);

        return response()->json(['date' => ['id' => $chat->id]]);
    }

    public function update(AssistantChatRequest $request, AssistantChat $chat)
    {
        $message = $request->validated();

        SendMessageToAI::dispatch($chat, $message);

        return response()->json(['message' => 'ok'], 202);
    }
}
