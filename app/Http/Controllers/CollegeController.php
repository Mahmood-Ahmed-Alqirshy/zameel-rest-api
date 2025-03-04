<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollegeRequest;
use App\Models\College;
// use App\Http\Requests\CollegeRequest;
use App\Policies\CollegePolicy;
use Illuminate\Http\Request;
use Orion\Concerns\DisablePagination;
use Orion\Http\Controllers\Controller;

class CollegeController extends Controller
{
    use DisablePagination;

    public function beforeDestroy(Request $request, $college)
    {
        if ($college->majors()->exists()) {
            return response()->json('Cannot delete college with majors', 422);
        }
    }

    protected $model = College::class;

    protected $policy = CollegePolicy::class;

    protected $request = CollegeRequest::class;
}
