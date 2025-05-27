<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\File;
use App\Models\Post;
use App\Policies\PostPolicy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Orion\Concerns\DisablePagination;
use Orion\Http\Controllers\Controller;

class PostController extends Controller
{
    use DisablePagination;

    protected $model = Post::class;

    protected $policy = PostPolicy::class;

    protected $request = PostRequest::class;

    public const EXCLUDE_METHODS = ['update', 'restore'];

    protected function buildIndexFetchQuery(Request $request, array $requestedRelations): Builder
    {
        $query = parent::buildIndexFetchQuery($request, $requestedRelations);

        $user = Auth::user();

        if (Gate::forUser($user)->check('admin')) {
            $query->admin();
        } elseif (Gate::forUser($user)->any(['manager', 'academic'])) {
            $query->academic();
        } else {
            $query->student();
        }

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

        $query = Post::onlyTrashed();
        $user = Auth::user();

        if (Gate::forUser($user)->check('admin')) {
            $query->admin();
        } elseif (Gate::forUser($user)->any(['manager', 'academic'])) {
            $query->academic();
        } else {
            $query->student();
        }

        $pass = Validator::make(
            ['cursor' => $request->query('cursor', Carbon::now())],
            ['cursor' => ['sometimes', Rule::date()->format('Y-m-d H:i:s')]]
        )->passes();
        $time = $pass ? $request->query('cursor', Carbon::now()) : Carbon::now();
        $query->where('deleted_at', '>', $time)->latest()->take(12);

        return response()->json(['data' => $query->get()]);
    }

    public function alwaysIncludes(): array
    {
        return ['files'];
    }

    public function exposedScopes(): array
    {
        return [
            'student',
            'academic',
            'admin',
        ];
    }

    public function filterableBy(): array
    {
        return ['created_at', 'subject_id', 'user_id'];
    }

    protected function performFill(Request $request, Model $entity, array $attributes): void
    {
        $entity->fill(
            [...Arr::except($attributes, 'attachment'), 'user_id' => Auth::user()->id]
        );
    }

    protected function afterSave(Request $request, $post): void
    {
        if (is_null($request->attachment)) {
            return;
        }

        $request->attachment['type'];
        if ($request->attachment['type'] === 'images') {
            for ($i = 0; $i < count($request->attachment['images']); $i++) {
                $file = $request->file('attachment.images.'.$i);
                $path = Storage::put('posts/images', $file);
                File::create([
                    'type' => 'image',
                    'name' => $file->getClientOriginalName(),
                    'ext' => $file->getClientOriginalExtension(),
                    'url' => $path,
                    'post_id' => $post->id,
                ]);
            }
        } else { /* file */
            $file = $request->file('attachment.file');
            $path = Storage::put('posts/files', $file);
            File::create([
                'type' => 'file',
                'name' => $file->getClientOriginalName(),
                'ext' => $file->getClientOriginalExtension(),
                'url' => $path,
                'post_id' => $post->id,
            ]);
        }
    }

    protected function beforeDestroy(Request $request, Model $post)
    {

        $files = $post->files();
        $files->each(function ($file) {
            Storage::delete($file->url);
        });
        $files->delete();
    }
}
