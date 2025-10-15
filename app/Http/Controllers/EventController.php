<?php

namespace App\Http\Controllers;

use App\Imports\StudentImport;
use App\Models\EventType;
use Illuminate\Http\Request;

use App\Models\Student;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
{
 // Assuming you have a Student model

//  protected $fillable = ['name', 'school', 'contact', 'email'];

public function store(Request $request)
{
    // Validate the form data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'school' => 'required|string|max:255',
        'contact' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ]);

    // Debugging example
    // dd($validatedData);

    // Store the validated data in the database
    Student::create($validatedData);

    return redirect()->back()->with('success', 'Student information submitted successfully.');
}

public function showRegisteredList()
{
    $students = Student::latest()->get(); // Retrieve all students, assuming you have a Student model

    return view('pages.reports.registeredlist', compact('students'));
}


public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        Excel::import(new StudentImport, $file);

        return redirect()->back()->with('success', 'Data imported successfully.');
    }



    public function index(Request $request)
    {
        if ($request->ajax()) {
            $students = Student::select('*');
            return DataTables::of($students)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                            $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('users');
    }

   

    public function delete($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
    
        return response()->json(['success' => 'Student deleted successfully.']);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'student_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Find the student
        $student = Student::findOrFail($request->student_id);

        // Update the student data
        $student->update($validatedData);

        return response()->json(['student' => $student, 'success' => 'Student updated successfully.']);
    }

    
    
}
