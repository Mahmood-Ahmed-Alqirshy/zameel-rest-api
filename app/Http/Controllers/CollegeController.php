<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollegeRequest;
use App\Http\Resources\CollegeResource;
use App\Models\College;

class CollegeController extends Controller
{
    public function index()
    {
        $colleges = College::all();
        return CollegeResource::collection($colleges);
    }

    public function store(CollegeRequest $request)
    {
        $data = $request->formattedData();
        $college = College::create($data['model']);
        return new CollegeResource($college);
    }

    public function show(College $college)
    {
        return new CollegeResource($college);
    }

    public function update(CollegeRequest $request, College $college)
    {
        $data = $request->formattedData();
        $college->update($data['model']);
        return new CollegeResource($college);
    }

    public function destroy(College $college)
    {
        if ($college->majors()->exists()) {
            return response()->json('Cannot delete college with majors', 422);;
        }

        $college->delete();
        return response()->json(null, 200);
    }
}
