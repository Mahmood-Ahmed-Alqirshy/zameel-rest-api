<?php

namespace App\Http\Controllers;

use App\Models\College;
use Orion\Http\Controllers\RelationController;

class CollegeMajorController extends RelationController
{
    protected $model = College::class;

    protected $relation = 'majors';
}
