<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;
use Orion\Http\Controllers\RelationController;

class MajorCollegeController extends RelationController
{
    protected $model = Major::class;

    protected $relation = 'college';

    public function beforeDestroy(Request $request, $major, $college)
    {
        $college->beforeDestroy($request, $college);
    }
}
