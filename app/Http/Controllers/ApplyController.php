<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyRequest;
use App\Models\Apply;
use App\Policies\ApplyPolicy;
use Orion\Concerns\DisablePagination;
use Orion\Http\Controllers\Controller;

class ApplyController extends Controller
{
    use DisablePagination;


    protected $model = Apply::class;

    protected $policy = ApplyPolicy::class;

    protected $request = ApplyRequest::class;

    protected $pivotFillable = ['note'];

    public const EXCLUDE_METHODS = ['update', 'batchUpdate', 'restore', 'batchRestore'];

    public function filterableBy(): array
    {
        return [
            'user_id',
            'group_id',
            'status_id',
            'created_at',
            'updated_at',
        ];
    }
}
