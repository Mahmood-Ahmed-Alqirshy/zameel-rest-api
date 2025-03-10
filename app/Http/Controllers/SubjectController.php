<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use App\Policies\SubjectPolicy;
use Illuminate\Http\Request;
use Orion\Concerns\DisablePagination;
use Orion\Http\Controllers\Controller;

class SubjectController extends Controller
{
    use DisablePagination;

    public function beforeDestroy(Request $request, $subject)
    {
        $subject->beforeDestroy($request, $subject);
    }

    protected $model = Subject::class;

    protected $policy = SubjectPolicy::class;

    protected $request = SubjectRequest::class;
}
