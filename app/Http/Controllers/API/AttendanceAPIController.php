<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAttendanceAPIRequest;
use App\Http\Requests\API\UpdateAttendanceAPIRequest;
use App\Models\Attendance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class AttendanceAPIController
 */
class AttendanceAPIController extends AppBaseController
{
    /**
     * Display a listing of the Attendances.
     * GET|HEAD /attendances
     */
    public function index(Request $request): JsonResponse
    {
        $query = Attendance::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $attendances = $query->get();

        return $this->sendResponse($attendances->toArray(), 'Attendances retrieved successfully');
    }

    /**
     * Store a newly created Attendance in storage.
     * POST /attendances
     */
    public function store(CreateAttendanceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Attendance $attendance */
        $attendance = Attendance::create($input);

        return $this->sendResponse($attendance->toArray(), 'Attendance saved successfully');
    }

    /**
     * Display the specified Attendance.
     * GET|HEAD /attendances/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Attendance $attendance */
        $attendance = Attendance::find($id);

        if (empty($attendance)) {
            return $this->sendError('Attendance not found');
        }

        return $this->sendResponse($attendance->toArray(), 'Attendance retrieved successfully');
    }

    /**
     * Update the specified Attendance in storage.
     * PUT/PATCH /attendances/{id}
     */
    public function update($id, UpdateAttendanceAPIRequest $request): JsonResponse
    {
        /** @var Attendance $attendance */
        $attendance = Attendance::find($id);

        if (empty($attendance)) {
            return $this->sendError('Attendance not found');
        }

        $attendance->fill($request->all());
        $attendance->save();

        return $this->sendResponse($attendance->toArray(), 'Attendance updated successfully');
    }

    /**
     * Remove the specified Attendance from storage.
     * DELETE /attendances/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Attendance $attendance */
        $attendance = Attendance::find($id);

        if (empty($attendance)) {
            return $this->sendError('Attendance not found');
        }

        $attendance->delete();

        return $this->sendSuccess('Attendance deleted successfully');
    }
}
