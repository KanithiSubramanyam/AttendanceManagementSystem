<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateJoinDateAPIRequest;
use App\Http\Requests\API\UpdateJoinDateAPIRequest;
use App\Models\JoinDate;
use App\Repositories\JoinDateRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class JoinDateAPIController
 */
class JoinDateAPIController extends AppBaseController
{
    private JoinDateRepository $joinDateRepository;

    public function __construct(JoinDateRepository $joinDateRepo)
    {
        $this->joinDateRepository = $joinDateRepo;
    }

    /**
     * Display a listing of the JoinDates.
     * GET|HEAD /join-dates
     */
    public function index(Request $request): JsonResponse
    {
        $joinDates = $this->joinDateRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($joinDates->toArray(), 'Join Dates retrieved successfully');
    }

    /**
     * Store a newly created JoinDate in storage.
     * POST /join-dates
     */
    public function store(CreateJoinDateAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $joinDate = $this->joinDateRepository->create($input);

        return $this->sendResponse($joinDate->toArray(), 'Join Date saved successfully');
    }

    /**
     * Display the specified JoinDate.
     * GET|HEAD /join-dates/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var JoinDate $joinDate */
        $joinDate = $this->joinDateRepository->find($id);

        if (empty($joinDate)) {
            return $this->sendError('Join Date not found');
        }

        return $this->sendResponse($joinDate->toArray(), 'Join Date retrieved successfully');
    }

    /**
     * Update the specified JoinDate in storage.
     * PUT/PATCH /join-dates/{id}
     */
    public function update($id, UpdateJoinDateAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var JoinDate $joinDate */
        $joinDate = $this->joinDateRepository->find($id);

        if (empty($joinDate)) {
            return $this->sendError('Join Date not found');
        }

        $joinDate = $this->joinDateRepository->update($input, $id);

        return $this->sendResponse($joinDate->toArray(), 'JoinDate updated successfully');
    }

    /**
     * Remove the specified JoinDate from storage.
     * DELETE /join-dates/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var JoinDate $joinDate */
        $joinDate = $this->joinDateRepository->find($id);

        if (empty($joinDate)) {
            return $this->sendError('Join Date not found');
        }

        $joinDate->delete();

        return $this->sendSuccess('Join Date deleted successfully');
    }
}
