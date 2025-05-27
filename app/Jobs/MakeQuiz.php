<?php

namespace App\Jobs;

use App\Models\Book;
use App\Models\Quiz;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;

class MakeQuiz implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private Book $book, private string $language = 'arabic') {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $text = PDFToText(Storage::url($this->book->path));
        $prompt = <<< prompt
            From the text below generate a quiz using $this->language language in JSON format containing:

            1. 3 Multiple Select Questions (MSQ): Each with a question, 4-5 options, and 1-3 correct answers.
            2. 2 True/False questions: Each with a statement and the correct boolean value.
            3. 2 Match the Following questions: Each with two lists of 3-5 items to be matched and the correct pairings.

            Format the output as a JSON object with keys: `msq`, `true_false`, and `match`. Ensure the entire output is valid JSON and nothing else (no explanations or comments).

            Here's the required JSON structure:

            {
            "msq": [
                {
                "question": "string",
                "options": ["string", "string", ...],
                "correct_answers": ["index of correct option", "index of correct option", ...]
                }
            ],
            "true_false": [
                {
                "statement": "string",
                "answer": true
                }
            ],
            "match": [
                {
                "left": ["string", "string", ...],
                "right": ["string", "string", ...],
                "matches": {
                    "index of left_item_1": "index of right_item_x",
                    ...
                }
                }
            ]
            }

            The text :

            $text
        prompt;
        $message = $prompt."\n\n".$text;
        $systemMessage = 'أنت تطبيق جامعي لمساعدة الطلاب في الدراس و تقوم بعمل اختبارات قصيرة للمواد الدراسية';

        $result = OpenAI::chat()->create([
            'model' => config('openai.summary_model'),
            'messages' => [
                ['role' => 'system', 'content' => $systemMessage],
                ['role' => 'user', 'content' => $message],
            ],
            'response_format' => ['type' => 'json_object'],
        ]);

        Quiz::create([
            'book_id' => $this->book->id,
            'content' => $result->choices[0]->message->content,
        ]);
    }
}
