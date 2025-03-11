<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Orion\Http\Controllers\RelationController;

class MajorGroupsController extends RelationController
{
    protected $model = Major::class;

    protected $relation = 'groups';
}
