<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateJoinDetailAPIRequest;
use App\Http\Requests\API\UpdateJoinDetailAPIRequest;
use App\Models\JoinDetail;
use App\Repositories\JoinDetailRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class JoinDetailAPIController
 */
class JoinDetailAPIController extends AppBaseController
{
    private JoinDetailRepository $joinDetailRepository;

    public function __construct(JoinDetailRepository $joinDetailRepo)
    {
        $this->joinDetailRepository = $joinDetailRepo;
    }

    /**
     * Display a listing of the JoinDetails.
     * GET|HEAD /join-details
     */
    public function index(Request $request): JsonResponse
    {
        $joinDetails = $this->joinDetailRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($joinDetails->toArray(), 'Join Details retrieved successfully');
    }

    /**
     * Store a newly created JoinDetail in storage.
     * POST /join-details
     */
    public function store(CreateJoinDetailAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $joinDetail = $this->joinDetailRepository->create($input);

        return $this->sendResponse($joinDetail->toArray(), 'Join Detail saved successfully');
    }

    /**
     * Display the specified JoinDetail.
     * GET|HEAD /join-details/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var JoinDetail $joinDetail */
        $joinDetail = $this->joinDetailRepository->find($id);

        if (empty($joinDetail)) {
            return $this->sendError('Join Detail not found');
        }

        return $this->sendResponse($joinDetail->toArray(), 'Join Detail retrieved successfully');
    }

    /**
     * Update the specified JoinDetail in storage.
     * PUT/PATCH /join-details/{id}
     */
    public function update($id, UpdateJoinDetailAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var JoinDetail $joinDetail */
        $joinDetail = $this->joinDetailRepository->find($id);

        if (empty($joinDetail)) {
            return $this->sendError('Join Detail not found');
        }

        $joinDetail = $this->joinDetailRepository->update($input, $id);

        return $this->sendResponse($joinDetail->toArray(), 'JoinDetail updated successfully');
    }

    /**
     * Remove the specified JoinDetail from storage.
     * DELETE /join-details/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var JoinDetail $joinDetail */
        $joinDetail = $this->joinDetailRepository->find($id);

        if (empty($joinDetail)) {
            return $this->sendError('Join Detail not found');
        }

        $joinDetail->delete();

        return $this->sendSuccess('Join Detail deleted successfully');
    }
}
