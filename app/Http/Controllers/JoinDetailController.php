<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJoinDetailRequest;
use App\Http\Requests\UpdateJoinDetailRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\JoinDetailRepository;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\JoinDetail;

use \Laracasts\Flash\Flash;

class JoinDetailController extends AppBaseController
{
    /** @var JoinDetailRepository $joinDetailRepository*/
    private $joinDetailRepository;

    public function __construct(JoinDetailRepository $joinDetailRepo)
    {
        $this->joinDetailRepository = $joinDetailRepo;
    }

    /**
     * Display a listing of the JoinDetail.
     */
    public function index(Request $request)
    {
        return view('join_details.index');
    }

    /**
     * Show the form for creating a new JoinDetail.
     */
    public function create()
    {   $employee = Employee::all();
        return view('join_details.create',compact('employee'));
    }

    /**
     * Store a newly created JoinDetail in storage.
     */
    public function store(CreateJoinDetailRequest $request)
    {
        $input = $request->all();

        $joinDetail = $this->joinDetailRepository->create($input);

        Flash::success('Join Detail saved successfully.');

        return redirect(route('joinDetails.index'));
    }

    /**
     * Display the specified JoinDetail.
     */
    public function show($id)
    {
        $joinDetail = $this->joinDetailRepository->find($id);

        if (empty($joinDetail)) {
            Flash::error('Join Detail not found');

            return redirect(route('joinDetails.index'));
        }
        return view('join_details.show')->with('joinDetail', $joinDetail);
    }

    /**
     * Show the form for editing the specified JoinDetail.
     */
    public function edit($id)
    {   
        $joinDetail = $this->joinDetailRepository->find($id);

        if (empty($joinDetail)) {
            Flash::error('Join Detail not found');

            return redirect(route('joinDetails.index'));
        }
        $employee = Employee::all();
        $join=JoinDetail::all();

        return view('join_details.edit',compact('employee','join'))->with('joinDetail', $joinDetail);
    }

    /**
     * Update the specified JoinDetail in storage.
     */
    public function update($id, UpdateJoinDetailRequest $request)
    {
        $joinDetail = $this->joinDetailRepository->find($id);

        if (empty($joinDetail)) {
            Flash::error('Join Detail not found');

            return redirect(route('joinDetails.index'));
        }

        $joinDetail = $this->joinDetailRepository->update($request->all(), $id);

        Flash::success('Join Detail updated successfully.');

        return redirect(route('joinDetails.index'));
    }

    /**
     * Remove the specified JoinDetail from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $joinDetail = $this->joinDetailRepository->find($id);

        if (empty($joinDetail)) {
            Flash::error('Join Detail not found');

            return redirect(route('joinDetails.index'));
        }

        $this->joinDetailRepository->delete($id);

        Flash::success('Join Detail deleted successfully.');

        return redirect(route('joinDetails.index'));
    }
}
