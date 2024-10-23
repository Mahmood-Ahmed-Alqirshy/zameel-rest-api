<?php

namespace App\Http\Controllers;

use App\Http\Requests\MajorRequest;
use App\Http\Resources\MajorResource;
use App\Models\Major;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::all();
        return MajorResource::collection($majors);
    }

    public function store(MajorRequest $request)
    {
        $data = $request->formattedData();
        $major = Major::create($data['model']);

        return new MajorResource($major);
    }

    public function show(Major $major)
    {
        return new MajorResource($major);
    }

    public function update(MajorRequest $request, Major $major)
    {
        $data = $request->formattedData();
        $major->update($data['model']);

        return new MajorResource($major);
    }

    public function destroy(Major $major)
    {
        if ($major->groups()->exists() || $major->subjects()->exists()) {
            return response()->json('Cannot delete this major', 422);
        }

        $major->delete();

        return response()->json(null, 200);
    }
}
