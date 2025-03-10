<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class College extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function majors(): HasMany
    {
        return $this->hasMany(Major::class);
    }

    public function posts(): MorphMany
    {
        return $this->morphMany(Post::class, 'taggable');
    }

    public function beforeDestroy(Request $request, $college)
    {
        $date = $request->validate(['force' => 'sometimes|boolean']);
        $isForceDelete = in_array(($date['force'] ?? 'false'), ['1', 1, 'true', true]);
        if ($isForceDelete && $college->majors()->exists()) {
            throw new UnprocessableEntityHttpException('Cannot delete college with majors');
        }
    }
}
