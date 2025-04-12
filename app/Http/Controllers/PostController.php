<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\File;
use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Orion\Http\Controllers\Controller;

class PostController extends Controller
{
    protected $model = Post::class;

    protected $policy = PostPolicy::class;

    protected $request = PostRequest::class;

    public const EXCLUDE_METHODS = ['index', 'update', 'batchStore', 'batchUpdate', 'batchDestroy'];

    public function alwaysIncludes(): array
    {
        return ['files'];
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
                $path = Storage::disk('file_server')->put('posts/images', $file);
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
            $path = Storage::disk('file_server')->put('posts/files', $file);
            File::create([
                'type' => 'file',
                'name' => $file->getClientOriginalName(),
                'ext' => $file->getClientOriginalExtension(),
                'url' => $path,
                'post_id' => $post->id,
            ]);
        }
    }

    protected function beforeDestroy(Request $request, Model $entity)
    {
        $entity->files()->delete();
    }
}
