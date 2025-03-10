<?php

namespace App\Http\Controllers;

use App\Http\Requests\MajorRequest;
use App\Models\Major;
use App\Policies\MajorPolicy;
use Illuminate\Http\Request;
use Orion\Concerns\DisablePagination;
use Orion\Http\Controllers\Controller;

class MajorController extends Controller
{
    use DisablePagination;

    protected $model = Major::class;

    protected $policy = MajorPolicy::class;

    protected $request = MajorRequest::class;

    public function beforeDestroy(Request $request, $major)
    {
        $major->beforeDestroy($request, $major);
    }
}
