<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Attendance;
use App\Models\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Laracasts\Flash\Flash;

class AttendanceController extends AppBaseController
{
    /**
     * Display a listing of the Attendance.
     */
    public function index(Request $request)
    {
        return view('attendances.index');
    }

    /**
     * Show the form for creating a new Attendance.
     */
    public function create()
    {
        $employee=Employee::all();
        return view('attendances.create',compact('employee'));
    }

    /**
     * Store a newly created Attendance in storage.
     */
    public function store(CreateAttendanceRequest $request)
    {  
        $input = $request->all();
        $maxSerialNumber = Attendance::max('s_no'); // Set the new serial number
        $input['s_no'] = $maxSerialNumber + 1;
        $maxSortNumber = Attendance::max('sort'); // Set the new serial number
        $input['sort'] = $maxSortNumber + 1;
    
        /** @var Attendance $attendance */
        $name = $request->input('name');// The name for which you want to check
        $date = $request->input('date'); // The date you want to check

        $hasDuplicateDate = DB::table('attendances')
        ->where('name', $name)
        ->where('date', $date)
        ->exists();

        if ($hasDuplicateDate) {
            // The name has a duplicate date
            Flash::error('Attendance date already exist.');

            return redirect(route('attendances.index'));
        } else { 

            $attendance = Attendance::create($input);
           
            Flash::success('Attendance saved successfully.');
    
            return redirect(route('attendances.index'));
        }
    }

    /**
     * Display the specified Attendance.
     */
    public function show($id)
    {
        /** @var Attendance $attendance */
        $attendance = Attendance::find($id);

        if (empty($attendance)) {
            Flash::error('Attendance not found');

            return redirect(route('attendances.index'));
        }

        return view('attendances.show')->with('attendance', $attendance);
    }

    /**
     * Show the form for editing the specified Attendance.
     */
    public function edit($id)
    {
        /** @var Attendance $attendance */
        $attendance = Attendance::find($id);
        
        if (empty($attendance)) {
            Flash::error('Attendance not found');

            return redirect(route('attendances.index'));
        }
        $employee=Employee::all();

        return view('attendances.edit',compact('employee'))->with('attendance', $attendance);
    }

    /**
     * Update the specified Attendance in storage.
     */
    public function update($id, UpdateAttendanceRequest $request)
    {
        /** @var Attendance $attendance */
        $attendance = Attendance::find($id);

        if (empty($attendance)) {
            Flash::error('Attendance not found');

            return redirect(route('attendances.index'));
        }
        $name = $request->input('name');// The name for which you want to check
        $date = $request->input('date');

        $hasDuplicateDate = DB::table('attendances')
            ->where('name', $name)
            ->where('date', $date)
            ->exists();


        if($request->input('attendance')==='Absent'){
            $attendance->fill($request->all());
            $attendance->save();

        Flash::success('Attendance updated successfully.');

        return redirect(route('attendances.index'));
        }
        elseif($request->input('attendance')==='Present'){
            $attendance->fill($request->all());
            $attendance->save();

        Flash::success('Attendance updated successfully.');

        return redirect(route('attendances.index'));
        }
        else{
        if ($hasDuplicateDate) {
            // The name has a duplicate date
            Flash::error('Attendance date already exist.');

            return redirect(route('attendances.index'));
        } else {
           
        $attendance->fill($request->all());
        $attendance->save();

        Flash::success('Attendance updated successfully.');

        return redirect(route('attendances.index'));
        }
    }
    }
    /**
     * Remove the specified Attendance from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Attendance $attendance */
        $attendance = Attendance::find($id);
        dd($attendance);
            $attendance->delete();
            Flash::success('Attendance deleted successfully.');
            return redirect(route('attendances.index'));
       
    }
    

}
