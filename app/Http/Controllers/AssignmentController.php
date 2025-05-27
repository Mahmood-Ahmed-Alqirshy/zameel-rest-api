<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentRequest;
use App\Models\Assignment;
use App\Policies\AssignmentPolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Orion\Concerns\DisablePagination;
use Orion\Http\Controllers\Controller;

class AssignmentController extends Controller
{
    use DisablePagination;

    protected $model = Assignment::class;

    protected $policy = AssignmentPolicy::class;

    protected $request = AssignmentRequest::class;

    protected function buildIndexFetchQuery(Request $request, array $requestedRelations): Builder
    {
        $query = parent::buildIndexFetchQuery($request, $requestedRelations);

        $query->whereIn('group_id', Auth::user()->groups()->get()->pluck('id')->toArray());

        $pass = Validator::make(
            [
                'cursor' => $request->query('cursor', Carbon::now()),
                'before' => $request->query('before', 'false'),
            ],
            [
                'cursor' => ['sometimes', Rule::date()->format('Y-m-d H:i:s')],
                'before' => ['sometimes', Rule::in(['true', 'false'])],
            ]
        )->passes();

        $operator = $request->query('before', 'false') === 'true' ? '<' : '>';
        $time = $pass ? $request->query('cursor', Carbon::now()) : Carbon::now();
        $query->where('created_at', $operator, $time)->latest()->take(12);

        return $query;
    }

    public function deleted(Request $request)
    {
        $query = Assignment::onlyTrashed();

        $query->whereIn('group_id', Auth::user()->groups()->get()->pluck('id')->toArray());

        $pass = Validator::make(
            ['cursor' => $request->query('cursor', Carbon::now())],
            ['cursor' => ['sometimes', Rule::date()->format('Y-m-d H:i:s')]]
        )->passes();
        $time = $pass ? $request->query('cursor', Carbon::now()) : Carbon::now();
        $query->where('deleted_at', '>', $time)->latest()->take(12);

        return response()->json(['data' => $query->get()]);
    }

    public function filterableBy(): array
    {
        return ['due_date', 'subject_id', 'group_id', 'created_at'];
    }
}
