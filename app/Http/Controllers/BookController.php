<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Jobs\MakeQuiz;
use App\Jobs\SummarizeBook;
use App\Models\Book;
use App\Policies\BookPolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Orion\Concerns\DisablePagination;
use Orion\Http\Controllers\Controller;

class BookController extends Controller
{
    use DisablePagination;

    protected $model = Book::class;

    protected $policy = BookPolicy::class;

    protected $request = BookRequest::class;

    protected function buildIndexFetchQuery(Request $request, array $requestedRelations): Builder
    {
        $query = parent::buildIndexFetchQuery($request, $requestedRelations);

        $query->whereIn('group_id', Auth::user()->groups()->get()->pluck('id')->toArray());

        $pass = Validator::make(
            [
                'cursor' => $request->query('cursor', Carbon::now()),
                'before' => $request->query('before', 'false'),
            ],
            [
                'cursor' => ['sometimes', Rule::date()->format('Y-m-d H:i:s')],
                'before' => ['sometimes', Rule::in(['true', 'false'])],
            ]
        )->passes();

        $operator = $request->query('before', 'false') === 'true' ? '<' : '>';
        $time = $pass ? $request->query('cursor', Carbon::now()) : Carbon::now();
        $query->where('created_at', $operator, $time)->latest()->take(12);

        return $query;
    }

    public function deleted(Request $request)
    {

        $query = Book::onlyTrashed();

        $query->whereIn('group_id', Auth::user()->groups()->get()->pluck('id')->toArray());

        $pass = Validator::make(
            ['cursor' => $request->query('cursor', Carbon::now())],
            ['cursor' => ['sometimes', Rule::date()->format('Y-m-d H:i:s')]]
        )->passes();
        $time = $pass ? $request->query('cursor', Carbon::now()) : Carbon::now();
        $query->where('deleted_at', '>', $time)->latest()->take(12);

        return response()->json(['data' => $query->get()]);
    }

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
