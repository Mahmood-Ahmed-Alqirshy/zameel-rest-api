<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Orion\Http\Controllers\RelationController;

class GroupMajorController extends RelationController
{
    protected $model = Group::class;

    protected $relation = 'major';
}
