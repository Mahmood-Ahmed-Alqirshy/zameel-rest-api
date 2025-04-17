<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Policies\BookPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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
        ];
    }

    protected function performFill(Request $request, Model $entity, array $attributes): void
    {
        $attributes['path'] = Storage::put('books', $attributes['path']);
        $entity->fill($attributes);
    }

    protected function beforeDestroy(Request $request, Model $book)
    {
        Storage::delete($book->path);
    }
}
