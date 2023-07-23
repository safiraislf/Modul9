<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Employee List';

    // RAW SQL QUERY
    // $employees = DB::select('
    //     select *, employees.id as employee_id, positions.name as position_name
    //     from employees
    //     left join positions on employees.position_id = positions.id
    // ');

    // Query Builder
    // $employees = DB::table('employees')->select('employees.*','employees.id as employee_id', 'positions.name as position_name')
    // ->join('positions', 'positions.id', '=', 'employees.position_id')->get();
    // return view('employee.index', [
    //     'pageTitle' => $pageTitle,
    //     'employees' => $employees

    // Eloquent
        $employees = Employee::all();

        return view('employee.index', [
            'pageTitle' => $pageTitle,
            'employees' => $employees
         ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Raw SQL
        // $pageTitle = 'Create Employee';
        // $positions = DB::select('select * from positions');

        // Query Builder
        $pageTitle = 'Create Employee';
        // $positions = DB::table('positions')->get();

        // Elequent
        $positions = Position::all();
        return view('employee.create', compact('pageTitle','positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka'
        ];

        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'age' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get File
        $file = $request->file('cv');

        if ($file != null) {
            $originalFilename = $file->getClientOriginalName();
            $encryptedFilename = $file->hashName();

            // Store File
            $file->store('public/files');
        }

        // ELOQUENT
        $employee = New Employee;
        $employee->firstname = $request->firstName;
        $employee->lastname = $request->lastName;
        $employee->email = $request->email;
        $employee->age = $request->age;
        $employee->position_id = $request->position;

        if ($file != null) {
            $employee->original_filename = $originalFilename;
            $employee->encrypted_filename = $encryptedFilename;
        }

        $employee->save();

        return redirect()->route('employees.index');

    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pageTitle = 'Employee Detail';

    // RAW SQL QUERY
    // $employee = collect(DB::select('
    //     select *, employees.id as employee_id, positions.name as position_name
    //     from employees
    //     left join positions on employees.position_id = positions.id
    //     where employees.id = ?
    // ', [$id]))->first();

    // Query Builder
    // $employee = DB::table('employees')->select('employees.*', 'positions.name as position_name', 'positions.id as position_id')
    // ->leftJoin('positions', 'positions.id', '=', 'employees.position_id')
    // ->where('employees.id', $id)
    // ->first();
    // return view('employee.show', compact('pageTitle', 'employee'));

    // Eloquent
    $employee = Employee::find($id);
    return view('employee.show', compact('pageTitle', 'employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = 'Edit Employee';
        // $positions = DB::table('positions')->get();
        // $employee = DB::table('employees')
        //     ->select('*', 'employees.id as employee_id', 'positions.name as position_name')
        //     ->leftJoin('positions', 'employees.position_id', 'positions.id')
        //     ->where('employees.id', $id)
        //     ->first();

        // return view('employee.edit', compact('pageTitle', 'positions', 'employee'));

        //Eloquent
        $positions = Position::all();
        $employee = Employee::find($id);

        return view('employee.edit', compact('pageTitle', 'positions', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // DB::table('employees')
        // ->where('id', $id)
        // ->update([
        //     'firstname' => $request->input('firstName'),
        //     'lastname' => $request->input('lastName'),
        //     'email' => $request->input('email'),
        //     'age' => $request->input('age'),
        //     'position_id' => $request->input('position')
        // ]);
        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka'
        ];

        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'age' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get File
        $file = $request->file('cv');

        if ($file != null) {
            $originalFilename = $file->getClientOriginalName();
            $encryptedFilename = $file->hashName();

        }

        $employee= Employee::find($id);
        $employee->firstname = $request->firstName;
        $employee->lastname = $request->lastName;
        $employee->email = $request->email;
        $employee->age = $request->age;
        $employee->position_id = $request->position;
        // $employee->save();
        if ($request->hasFile('cv')){
            $file = $request->file('cv');

            // Simpan file baru
            $file->store('public/files');

            // Hapus file lama
            Storage::delete('public/files/'.$employee->encrypted_filename);

            if ($file != null) {
                $employee->original_filename = $originalFilename;
                $employee->encrypted_filename = $encryptedFilename;
            }
        }
        $employee->save();
        return redirect()->route('employees.index');
    }

    // return view('employee.index', compact('pageTitle', 'employee'));


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            $file = 'public/files/'.$employee->encrypted_filename;
            if (!empty($file)) {
                 Storage::delete('/'.$file);
            }
            $employee->delete();
        }
        return redirect()->route('employees.index');
    }

    public function downloadFile($employeeId)
    {
        $employee = Employee::find($employeeId);
        $encryptedFilename = 'public/files/'.$employee->encrypted_filename;
        $downloadFilename = Str::lower($employee->firstname.'_'.$employee->lastname.'_cv.pdf');

        if(Storage::exists($encryptedFilename)) {
            return Storage::download($encryptedFilename, $downloadFilename);
        }
    }
}
