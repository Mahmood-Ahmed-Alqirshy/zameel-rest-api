<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use App\Policies\GroupPolicy;
use Orion\Http\Controllers\Controller;

class GroupController extends Controller
{
    protected $model = Group::class;

    protected $policy = GroupPolicy::class;

    protected $request = GroupRequest::class;

    public const EXCLUDE_METHODS = ['update', 'destroy', 'batchUpdate', 'batchDestroy', 'batchRestore'];

    public function filterableBy(): array
    {
        return ['created_at', 'major_id', 'join_year', 'division'];
    }
}
