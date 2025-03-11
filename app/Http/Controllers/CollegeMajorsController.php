<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;
use Orion\Http\Controllers\RelationController;

class CollegeMajorsController extends RelationController
{
    protected $model = College::class;

    protected $relation = 'majors';

    public function beforeDestroy(Request $request, $college, $major)
    {
        $major->beforeDestroy($request, $major);
    }
}
