<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssignedEmployee;
use App\Models\Employee;
use App\Models\EventType;
use App\Models\NewEvent;
use Illuminate\Support\Facades\DB;

use App\Models\Task;

class AssignedEmployeeController extends Controller
{
    // Show assigned employee list
    public function index()
    {
        $employee = Employee::select('*')->get();
        $event = NewEvent::select('*')->get();
        $assignTask = DB::table('assigned_emp')
            ->join('employees', 'assigned_emp.emp_id', '=', 'employees.id')
            ->join('tasks', 'assigned_emp.task_id', '=', 'tasks.id')
            ->join('event_types', 'tasks.event_type_id', '=', 'event_types.id')
            ->select(
                'assigned_emp.id',
                'employees.emp_id',
                'employees.emp_name',
                'tasks.task_name',
                'tasks.id AS task_id',
                'event_types.event_type'
            )
            ->get()->toArray();

        $tasks = [];
        foreach ($assignTask as $key1 => $task) {
            if (! (array_search($task->task_id, array_column($tasks, 'task_id')) !== False)) {
                $tasks[$task->task_id]['task_id'] = $task->task_id;
                $tasks[$task->task_id]['event_type'] = $task->event_type;
                $tasks[$task->task_id]['task_name'] = $task->task_name;
            }

            $tasks[$task->task_id]['employees'][] = [
                'id' => $task->id,
                'emp_id' => $task->emp_id,
                'emp_name' => $task->emp_name,
            ];
        }

        return view('pages.assigned_employee.assigned_employee_list', [
            'employee' => $employee,
            'event' => $event,
            'assignTask' => $tasks
        ]);
    }

    public function fetchall($results)
    {
        $results = DB::table('assigned_emp')
            ->join('employees', 'assigned_emp.emp_id', '=', 'employees.id')
            ->join('tasks', 'assigned_emp.task_id', '=', 'tasks.id')
            ->join('event_types', 'tasks.event_type_id', '=', 'event_types.id')
            ->select(
                'employees.emp_id',
                'employees.emp_name',
                'tasks.task_name',
                'event_types.event_type'
            )
            ->get()
            ->toArray(); // Converts collection to raw array like fetchAll()
    }

    public function gettaskbyevent($event_id)
    {
        // new_events table එකෙන් event_type_id එක ගන්නවා
        $event = NewEvent::find($event_id);

        if (!$event) {
            return response()->json([]); // Event එක හම්බුනේ නැත්නම් empty response එකක්
        }

        // ඒ event_type_id එකට අදාල task select කරන්න
        $tasks = Task::select('id', 'task_name')
            ->where('event_type_id', $event->event_type_id)
            ->get();

        return response()->json($tasks);
    }

    // Store new assignment
    public function store(Request $request)
    {
        $request->validate([
            'emp_id' => 'required|exists:employees,id',
            'task' => 'required|string|max:255',
        ]);

        $assigned = AssignedEmployee::create([
            'task_id' => $request->task,
            'emp_id' => $request->emp_id,

        ]);

        if ($assigned) {
            return redirect()->back()->with('success', "Employee Assigned Successfully");
        } else {
            return redirect()->back()->with('error', "Error on assigning");
        }
    }



    // Show data for edit modal via AJAX

    public function edit($id)
    {
        $data = DB::table('assigned_emp')
            ->join('employees', 'assigned_emp.emp_id', '=', 'employees.id')
            ->join('tasks', 'assigned_emp.task_id', '=', 'tasks.id')
            ->join('event_types', 'tasks.event_type_id', '=', 'event_types.id')
            ->where('assigned_emp.id', $id)
            ->select(
                // 'assigned_emp.id',
                'employees.id as emp_id',

                // 'employees.emp_name',
                'tasks.task_name',
                'event_types.event_type',
                'tasks.id as task_id',
                'tasks.event_type_id as event_id'
            )
            ->first();

        return response()->json($data);
    }



    // Update assignment
    public function update(Request $request, $id)
    {
        $request->validate([
            'emp' => 'required|exists:employees,id',
        ]);

        $updated = AssignedEmployee::where('id', $id)->update([
            'emp_id' => $request->emp,
        ]);

        if ($updated) {
            return redirect()->back()->with('success', 'Assigned employee updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Update failed!');
        }
    }



    // Delete assignment
    public function destroy($id)
    {
        $assigned = AssignedEmployee::findOrFail($id);
        $assigned->delete();

        return response()->json(['success' => true, 'message' => 'Assignment deleted successfully.']);
    }
}
