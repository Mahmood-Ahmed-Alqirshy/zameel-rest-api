<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use App\Policies\GroupPolicy;
use Orion\Concerns\DisablePagination;
use Orion\Http\Controllers\Controller;

class GroupController extends Controller
{
    use DisablePagination;

    protected $model = Group::class;

    protected $policy = GroupPolicy::class;

    protected $request = GroupRequest::class;

    public const EXCLUDE_METHODS = ['search', 'update', 'destroy', 'restore', 'batchUpdate', 'batchDestroy', 'batchRestore', 'dissociate'];
}
