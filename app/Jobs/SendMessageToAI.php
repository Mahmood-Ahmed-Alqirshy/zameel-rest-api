<?php

namespace App\Jobs;

use App\Events\AssistantResponded;
use App\Models\AssistantChat;
use App\Models\Book;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;

class SendMessageToAI implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private AssistantChat $chat, private array $message) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $text = $this->message['message'];
        if (array_key_exists('book_id', $this->message)) {
            $book = Book::find($this->message['book_id']);
            $text .= "\n\n".PDFToText(Storage::url($book->path));
        }

        $messages = array_merge($this->chat->messages, [['role' => 'user', 'content' => $text]]);

        $result = OpenAI::chat()->create([
            'model' => config('openai.chat_model'),
            'messages' => $messages,
        ]);

        $messages = array_merge($messages, [['role' => 'assistant', 'content' => $result->choices[0]->message->content]]);
        $this->chat->messages = $messages;
        $this->chat->save();

        AssistantResponded::dispatch($this->chat, $result->choices[0]->message->content);
    }
}
