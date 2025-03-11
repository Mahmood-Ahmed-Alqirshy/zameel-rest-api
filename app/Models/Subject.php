<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function posts(): MorphMany
    {
        return $this->morphMany(Post::class, 'taggable');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function beforeDestroy(Request $request, $subject)
    {
        $data = $request->validate(['force' => 'sometimes|boolean']);
        $isForceDelete = in_array(($date['force'] ?? 'false'), ['1', 1, 'true', true]);
        $isHasAssignments = $subject->assignments()->exists();
        $isHasBooks = $subject->books()->exists();
        if ($isForceDelete && ($isHasAssignments || $isHasBooks)) {
            throw new UnprocessableEntityHttpException('Cannot delete subject with related assignments or books');
        }
    }
}
