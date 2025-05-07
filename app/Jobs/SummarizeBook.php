<?php

namespace App\Jobs;

use App\Models\Book;
use App\Models\Summary;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;

class SummarizeBook implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private Book $book, private string $language = 'العربية')
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $text = PDFToText(Storage::url($this->book->path));
        $prompt = 'قم بتلخيص النص التالي بشكل شديد ومباشر باستخدام الفقرات القصيرة (لا تتجاوز سطرين لكل فقرة) والنقاط (لا تتجاوز 7 كلمات لكل نقطة)، مع إدراج جداول أو أمثلة توضيحية فقط إذا احتاج النص للشرح أو التوضيح. استخدم اللغة '.$this->language.' وحافظ على المعنى الكامل والدقة قدر الإمكان، ورتب المعلومات بطريقة منطقية ومنظمة';
        $message = $prompt."\n\n".$text;
        $systemMessage = 'أنت تطبيق جامعي لمساعدة الطلاب في الدراس و تقوم بعمل تلخيص للمواد الدراسية';

        $result = OpenAI::chat()->create([
            'model' => config('openai.summary_model'),
            'messages' => [
                ['role' => 'system', 'content' => $systemMessage],
                ['role' => 'user', 'content' => $message],
            ],
        ]);

        Summary::create([
            'book_id' => $this->book->id,
            'content' => $result->choices[0]->message->content,
        ]);
    }
}
