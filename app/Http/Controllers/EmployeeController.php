<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use \Laracasts\Flash\Flash;

class EmployeeController extends AppBaseController
{
    /** @var EmployeeRepository $employeeRepository*/
    private $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepo)
    {
        $this->employeeRepository = $employeeRepo;
    }

    /**
     * Display a listing of the Employee.
     */
    public function index(Request $request)
    {
        return view('employees.index');
    }

    /**
     * Show the form for creating a new Employee.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created Employee in storage.
     */
    public function store(CreateEmployeeRequest $request)
    {
        $input = $request->all();
        $image=$request->file('image');
        $image_name=$image->getClientOriginalName();
        $destination='/public/uploads';
        $path=$image->storeAs($destination,$image_name);
        $input['image']=$image_name;
        $employee = $this->employeeRepository->create($input);

        Flash::success('Employee saved successfully.');

        return redirect(route('employees.index'));
    }

    /**
     * Display the specified Employee.
     */
    public function show($id)
    {
        $employee = $this->employeeRepository->find($id);

        if (empty($employee)) {
            Flash::error('Employee not found');

            return redirect(route('employees.index'));
        }

        return view('employees.show')->with('employee', $employee);
    }

    /**
     * Show the form for editing the specified Employee.
     */
    public function edit($id)
    {
        $employee = $this->employeeRepository->find($id);

        if (empty($employee)) {
            Flash::error('Employee not found');

            return redirect(route('employees.index'));
        }

        return view('employees.edit')->with('employee', $employee);
    }

    /**
     * Update the specified Employee in storage.
     */
    public function update($id, UpdateEmployeeRequest $request)
    {
        $employee = $this->employeeRepository->find($id);

        if (empty($employee)) {
            Flash::error('Employee not found');

            return redirect(route('employees.index'));
        }
        if($request->hasFile('image')){
            $image=$request->file('image');
            $image_name=$image->getClientOriginalName();
            $destination='/public/uploads';
            $path=$image->storeAs($destination,$image_name);
            $input = $request->all();
            $input['image']=$image_name;
        }
        else{
            $input = $request->all();

        }
        $employee = $this->employeeRepository->update($input, $id);

        Flash::success('Employee updated successfully.');

        return redirect(route('employees.index'));
    }

    /**
     * Remove the specified Employee from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $employee = $this->employeeRepository->find($id);

        if (empty($employee)) {
            Flash::error('Employee not found');

            return redirect(route('employees.index'));
        }

        $this->employeeRepository->delete($id);

        Flash::success('Employee deleted successfully.');

        return redirect(route('employees.index'));
    }
}
