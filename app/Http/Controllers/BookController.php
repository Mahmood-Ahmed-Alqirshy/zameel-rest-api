<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Jobs\MakeQuiz;
use App\Jobs\SummarizeBook;
use App\Models\Book;
use App\Policies\BookPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Orion\Http\Controllers\Controller;

class BookController extends Controller
{
    protected $model = Book::class;

    protected $policy = BookPolicy::class;

    protected $request = BookRequest::class;

    public function filterableBy(): array
    {
        return [
            'subject_id',
            'group_id',
            'is_practical',
            'year',
            'semester',
            'created_at',
        ];
    }

    protected function performFill(Request $request, Model $entity, array $attributes): void
    {
        $attributes['path'] = Storage::put('books', $attributes['path']);
        $entity->fill(Arr::except($attributes, 'is_arabic'));
    }

    protected function afterStore(Request $request, Model $book)
    {
        $languageAR = ($request->is_arabic) ? 'العربية' : 'الإنجليزية';
        $languageEN = ($request->is_arabic) ? 'arabic' : 'english';

        SummarizeBook::dispatch($book, $languageAR);
        MakeQuiz::dispatch($book, $languageEN);
    }

    protected function beforeDestroy(Request $request, Model $book)
    {
        Storage::delete($book->path);
    }
}
