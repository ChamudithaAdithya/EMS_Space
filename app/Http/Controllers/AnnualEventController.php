<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\AnnualEvent;
use App\Models\AssignedEmployee;
use App\Models\EventType;
use App\Models\NewEvent;
use App\Models\SubTask;
use App\Models\Task;
use App\Models\EventInstanceTask;
use App\Models\InstanceTaskAssign;
use App\Models\InstanceTasksAssign;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Log;
use League\CommonMark\Node\Inline\Newline;

class AnnualEventController extends Controller
{
    public function index1()
    {
        $events = EventType::all(); // Retrieve all events from the database
        return view('pages.space_event_type.space_event_type_list_by_EVENT', [
            'events' => $events,
        ]);
    }


    /**
     * This function handles the creation of a new event.
     *
     * @param Request $request The incoming request containing the event ID.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory Returns a view with necessary data for creating a new event.
     */
    public function createEvent(Request $request)
    {
        // Retrieve the event ID from the request
        $id = $request->input('event_id');

        // Fetch the event type name based on the provided ID
        $eventNameObj = EventType::where('id', $id)->select('event_type')->first();
        $eventName = $eventNameObj->event_type;   //get event name from the name object

        // Retrieve all tasks associated with the provided event type ID
        $tasklist = Task::where('event_type_id', $id)
            ->select('id', 'task_name')->get();

        // Retrieve all coordinators
        $coordinators = Employee::all();

        // Retrieve all event types
        $events = EventType::all(); //harindu

        // Pass the necessary data to the view for creating a new event
        return view(
            'pages.space_event_type.createEvent',
            compact('coordinators', 'id', 'tasklist', 'events', 'eventName')
        );
    }


    public function viewEvent(Request $request)
    {
        // Retrieve event type and event name based on the event ID
        $eventType = EventType::select('id', 'event_type')
            ->where('id', $request->event_id)
            ->first();

        $eventname = NewEvent::where('id', $request->event_id)
            ->select('event_name', 'id', 'event_type_id')
            ->get();


        //$subtasks = SubTask::where('emp_assign','id', $request->emp_assign)
        //    ->select('emp_assign')
        //    ->get();

        // $docs = Task::where('event_type_id', $request->event_id)
        //     ->select('attachment')
        //     ->get();

        // Return view with event data
        return view('pages.space_event_type.eventReportView', [
            'eventname' => $eventname,
            'eventType' => $eventType,
            // 'year' => $year,
            //'eventinstancetasks' => $eventinstancetask,
            // 'subtasks'=>$subtasks,
            // 'docs' => $docs,
        ]);
    }

    /**
     * This function retrieves and displays completed events based on the provided event type ID.
     *
     * @param int $eventTypeId The ID of the event type for which completed events need to be fetched.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory Returns a view with completed events data.
     * The view is located at 'pages.space_event_type.spaceCompletedEvents'.
     * The view receives an associative array with a key 'completedEvents' containing the fetched completed events data.
     */
    public function completedEvents($eventTypeId)
    {
        $completedEvents = NewEvent::where('event_type_id', $eventTypeId)->where('active_status', 'completed')->get();

        $eventTypeName = EventType::select('event_type')->where('id', $eventTypeId)->first();

        return view('pages.space_event_type.spaceCompletedEvents', [
            'completedEvents' => $completedEvents,
            'eventTypeName' => $eventTypeName

        ]);
    }

    public function completedEvent($eventTypeId)
    {
        $completedEvent = NewEvent::where('id', $eventTypeId)->where('active_status', 'completed')->first();

        $eventTypeName = EventType::select('event_type')->where('id', $completedEvent->event_type_id)->first();

        //dd($completedEvent);
        return view('pages.space_event_type.completedEvent', [
            'completedEvent' => $completedEvent,
            'eventTypeName' => $eventTypeName,
            //'eventinstancetasks' => $eventinstancetask
        ]);
    }

    /**
     * This function retrieves and displays a single running event based on the provided event type ID.
     *
     * @param int $eventTypeId The ID of the event type for which the running event needs to be fetched.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory Returns a view with the running event data.
     * The view is located at 'pages.space_event_type.runnigEvents'.
     * The view receives an associative array with a key 'runnigEvent' containing the fetched running event data.
     */
    // 
    // public function runnigEvent($newEventId)
    // {
    //     $runnigEvent = DB::table('new_event')
    //         ->select('new_event.*', 'employees.emp_name')
    //         ->leftJoin('employees', 'new_event.coordinator', '=', 'employees.id')
    //         ->where([
    //             'new_event.id' => $eventTypeId,
    //             'new_event.active_status' => 'running'
    //         ])
    //         ->first();

    //     if (!$runnigEvent) {
    //         abort(404, 'Running event not found.');
    //     }

    //     $eventTypeName = EventType::select('event_type')->where('id', $runnigEvent->event_type_id)->first();

    //     // ✅ Task list එක ගන්න
    //     $eventinstancetasks = EventInstanceTask::with('task')->where('new_event_id', $newEventId)->get();
    //      echo '<pre>' ; print_r($eventinstancetasks); exit;

    //     // ✅ Assign කරන ලද employeeලා (task_id අනුව group කරනවා)
    //     $assignedEmployees = DB::table('assigned_emp')
    //         ->join('employees', 'assigned_emp.emp_id', '=', 'employees.id')
    //         ->select('assigned_emp.task_id', 'employees.emp_name')
    //         ->get()
    //         ->groupBy('task_id'); // Task එකකට අදාළව group කරලා තියෙනවා

    //     return view('pages.space_event_type.runnigEvents', [
    //         'runnigEvent' => $runnigEvent,
    //         'eventTypeName' => $eventTypeName,
    //         'eventinstancetasks' => $eventinstancetasks,
    //         'assignedEmployees' => $assignedEmployees

    //     ]);
    // }

    public function showRunningEvent($eventId)
    {
        $runnigEvent = NewEvent::findOrFail($eventId);

        $eventinstancetasks = EventInstanceTask::with('tasks')
            ->where('event_id', $eventId)
            ->get();

        $eventTypeName = EventType::find($runnigEvent->event_type_id);

        // Get assigned employees grouped by task_id
        $assignedEmployees = DB::table('assigned_emp')
            ->join('employees', 'assigned_emp.emp_id', '=', 'employees.id')
            ->select('assigned_emp.tasks_id as task_id', 'employees.emp_name')
            ->get()
            ->groupBy('task_id');


        return view('pages.running_event.task_list', [
            'runnigEvent' => $runnigEvent,
            'eventinstancetasks' => $eventinstancetasks,
            'eventTypeName' => $eventTypeName,
            'assignedEmployees' => $assignedEmployees,
        ]);
    }

    public function destroy($id)
    {
        $event = EventType::findOrFail($id);
        $event->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Event deleted successfully.']);
        }

        return redirect()->back()->with('success', 'Event deleted successfully.');
    }








    /**
     * This function retrieves and displays a single running event based on the provided new event ID.
     *
     * @param int $eventTypeId The ID of the event type for which the running event needs to be fetched.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory Returns a view with the running event data.
     * The view is located at 'pages.space_event_type.runnigEvents'.
     * The view receives an associative array with a key 'runnigEvent' containing the fetched running event data.
     */
    public function runnigEvents($newEventId)
    {
        $runnigEvent = DB::table('new_event')
            ->select('new_event.*', 'employees.emp_name')
            ->leftJoin('employees', 'new_event.coordinator', '=', 'employees.id')
            ->where([
                'new_event.id' => $newEventId,
                'new_event.active_status' => 'running'
            ])
            ->first();

        $eventTypeName = DB::table('event_types')
            ->select('event_types.event_type')
            ->leftJoin('new_event', 'new_event.event_type_id', '=', 'event_types.id')
            ->where([
                'new_event.id' => $newEventId,
            ])
            ->first();

        $instancetasks = DB::table('event_instance_tasks')
            ->select(
                'tasks.task_name',
                'tasks.id AS tasks_id',
                'event_instance_tasks.id',
                'event_instance_tasks.status',
                'instance_tasks_assign.assigned_emp_id',
                'instance_tasks_assign.status AS emp_status'
            )
            ->leftJoin('tasks', 'tasks.id', '=', 'event_instance_tasks.tasks_id')
            ->leftJoin('instance_tasks_assign', 'instance_tasks_assign.event_instance_task_id', '=', 'event_instance_tasks.id')
            ->where([
                'event_instance_tasks.new_event_id' => $newEventId,
            ])
            ->get()->toArray();

        $eventinstancetasks = $assignedList = [];
        foreach ($instancetasks as $key1 => $task) {
            if (! (array_search($task->tasks_id, array_column($eventinstancetasks, 'tasks_id')) !== False)) {
                $eventinstancetasks[$task->tasks_id]['tasks_id'] = $task->tasks_id;
                $eventinstancetasks[$task->tasks_id]['task_name'] = $task->task_name;
                $eventinstancetasks[$task->tasks_id]['id'] = $task->id;
                $eventinstancetasks[$task->tasks_id]['status'] = $task->status;
            }

            if (!empty($task->assigned_emp_id)) {
                $assignedList[$task->id][$task->assigned_emp_id] = [
                    'emp_status' => $task->emp_status,
                ];
            }
        }

        // // Get assigned employees grouped by task_id
        $assignedEmployees = DB::table('assigned_emp')
            ->join('employees', 'assigned_emp.emp_id', '=', 'employees.id')
            ->select('assigned_emp.task_id', 'employees.emp_name', 'assigned_emp.id')
            ->get()
            ->groupBy('task_id')
            ->toArray();

        return view('pages.space_event_type.runnigEvents', [
            'runnigEvent' => $runnigEvent,
            'eventTypeName' => $eventTypeName,
            'eventinstancetasks' => $eventinstancetasks,
            'assignedEmployees' => $assignedEmployees,
            'assignedList' => $assignedList
        ]);
    }



    public function viewEventById(Request $request, $eventId)
    {
        Log::info($request);
        $this->eventId = $eventId;

        // Retrieve event data based on the event ID
        $eventData = NewEvent::where('id', $eventId)
            ->select('*')
            ->get();

        $employees = Employee::select('*')->get();


        $tasks = SubTask::where('new_event_id', $eventId)
            ->select('tasks', 'emp_assign', 'status', 'id')
            ->get();

        $assign_employee = SubTask::where('id', $request->id)
            ->select('emp_assign')->get();


        // Join the SubTask and Employee tables to get the employee name
        $tasks = SubTask::leftJoin('employees', 'sub_tasks.emp_assign', '=', 'employees.emp_id')
            ->where('new_event_id', $eventId)
            ->select('sub_tasks.tasks', 'sub_tasks.emp_assign', 'sub_tasks.status', 'employees.emp_name')
            ->get();

        //new
        // $eventinstancetask = EventInstanceTask::where('event_type_id', $request->id)
        // ->select('task_name', 'id', 'event_type_id')
        // ->get();



        // Return JSON response with rendered view and event data
        return response()->json([
            'html' => view(
                'pages.space_event_type.eventReportById',
                compact('eventData', 'tasks', 'employees', 'assign_employee')
            )->render(),
        ]);
    }

    public function assignEmployee(Request $request)
    {
        // Validate inputs
        $request->validate([
            'new_event_id' => 'required',
            'event_name' => 'required',
            'employee_id' => 'required',
        ]);

        // Retrieve data from the request
        $new_event_id = $request->input('new_event_id');
        $event_name = $request->input('event_name');
        $employee_id = $request->input('employee_id');


        // Update the emp_assign column for the corresponding subtask
        $subtask = SubTask::where('new_event_id', $new_event_id)
            ->where('tasks', $event_name)
            ->update(['emp_assign' => $employee_id]);

        // Check if any rows were affected by the update operation
        if ($subtask > 0) {
            // Retrieve the employee's name
            $employee = Employee::find($employee_id);

            // Respond with a success message and employee's name
            return response()->json([
                'success' => true,
                'message' => 'Employee assigned successfully.',
                'employee_name' => $employee->emp_name
            ]);
        } else {
            // Respond with an error message if no rows were affected
            return response()->json([
                'success' => false,
                'message' => 'No matching records found.',
            ]);
        }
    }


    // Method to fetch and return employees data
    public function getEmployees(Request $request)
    {
        // Retrieve employees from the database
        $employees = SubTask::where('new_event_id', $request->new_event_id)
            ->pluck('emp_assign');
        // ->select('emp_assign')
        // ->get();

        // Return the employees data as JSON response
        return response()->json(['employees' => $employees]);
    }

    public function status(Request $request)
    {
        $request->validate([
            'task_id' => 'required|integer|exists:sub_tasks,id',
        ]);

        $task = SubTask::find($request->input('task_id'));
        $task->status = $task->status == 1 ? 0 : 1; // Toggle status
        $task->save();

        return response()->json([
            'success' => true,
            'message' => 'Task status updated successfully.',
        ]);
    }

    // public function assignemployee(Request $request, $event_id, $event_name)
    // {
    //     $employee_ids = $request->input('employees');

    //    // Retrieve all subtasks for the given event and task
    // $subtasks = SubTask::where('new_event_id', $event_id)
    // ->where('tasks', $event_name)
    // ->get();

    // foreach ($subtasks as $index => $subtask) {
    //     // Check if an employee ID is available for the current task
    //     if (isset($employee_ids[$index])) {
    //         $employee_id = $employee_ids[$index];
    //         // Update emp_assign for the current subtask
    //         $subtask->update(['emp_assign' => $employee_id]);
    //     } else {
    //         // Handle case where no employee is selected for the current task
    //         // You may want to implement error handling or provide a default behavior
    //     }
    // }
    // Respond with a success message
    //     return response()->json(['message' => 'Employees assigned successfully.']);
    // }

    //correct one
    // $eventname = NewEvent::where('id', $event_id)
    // ->select('event_name','id')->get();

    // return response()->json([
    //     'html' => view('pages.space_event_type.eventReportById',compact('eventname'))->render(),
    // ]);
    // }




    /* public function index()
    {
        $annual_events = AnnualEvent::orderBy('start_date', 'ASC')->get();

        return view('admin.dashboard', [
            'annual_events' => $annual_events,
        ]);
    }
 */

    public function upcomingEvents()
    {
        $currentDate = Carbon::now()->today();
        $endOfWeek = Carbon::now()->addDays(50);

        $upcomingEvents = NewEvent::whereBetween('start_date', [
            $currentDate,
            $endOfWeek,
        ])
            ->orderBy('start_date')
            ->get();
        return view('admin.dashboard', compact('upcomingEvents'));
    }


    public function store(Request $request)
    {
        //check if the event name is already exists
        $exsistingEventName = NewEvent::where('event_name', $request->event_name)->first();

        if ($exsistingEventName) {
            return response()->json([
                'success' => false,
                'message' => 'Event name already exists',
            ]);
        }

        // Validation rules
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        // Check if validation failed
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message'  => $validator->errors()->first()
            ]);
        }

        Log::info('Validation passed');

        try {
            // Create the new event
            $createdEvent = NewEvent::create([
                'event_name' => $request->event_name,
                'event_type_id' => $request->event_type_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'coordinator' => $request->coordinator,
                'active_status' => 'running'
            ]);

            // Handle tasks
            $taskNames = $request->input('tasks', []);
            Log::info($taskNames);
            foreach ($taskNames as $taskName) {
                //Log::info( $taskName);
                try {
                    EventInstanceTask::create([
                        'new_event_id' => $createdEvent->id,
                        'tasks_id' => $taskName,
                        'status' => 'todo'
                    ]);
                    //Log::info('SubTask created', ['taskName' => $taskName]);
                } catch (\Exception $e) {
                    Log::error('Error creating SubTask', ['exception' => $e->getMessage()]);
                    // Rollback the event creation if a subtask fails
                    $createdEvent->delete(); // Remove the created event
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to create tasks for the event.'
                    ]);
                }
            }


            return response()->json([
                'success' => true,
                'message' => 'Event created successfully.',
                'event_id' => $createdEvent->id
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating event', ['exception' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to create event.'
            ]);
        }
    } 


    public function show($event_id)
    {
        $event = NewEvent::where('id', $event_id)->first();
        // You can also retrieve other related data if needed

        return response()->json($event);
    }


    public function Report(Request $request)
    {
        // Fetch the event details based on the event_id
        $createdEvent = NewEvent::where('id', $request->event_id)->first();

        // Fetch the coordinator details
        $employee = Employee::where('emp_id', $request->coordinator)->get();

        // Fetch the tasks associated with the event type of the created event
        $tasks = Task::where('event_type_id', $createdEvent->event_id)->get();

        // Fetch the event type details
        $eventType = EventType::where('id', $createdEvent->event_id)->get();

        // Pass the fetched data to the view
        return view('pages.space_event_type.eventReport', [
            'createdEvent' => $createdEvent,
            'employee' => $employee,
            'tasks' => $tasks,
            'eventType' => $eventType,
        ]);
    }

    // public function updateTaskAssignStatus(Request $request)
    // {
    //     $request->validate([
    //         'task_id' => 'required|integer',
    //         'emp_id' => 'required|integer',
    //         'status' => 'required|in:done,todo',
    //     ]);

    //     DB::table('instance_tasks_assign')
    //         ->where('task_id', $request->task_id)
    //         ->where('emp_id', $request->emp_id)
    //         ->update(['status' => $request->status]);

    //     return response()->json(['success' => true]);
    // }
    public function updateTaskAssignStatus(Request $request)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $assignment = new InstanceTasksAssign();
        $assignment->status = 'Done';
        $assignment->event_instance_task_id = $request->event_instance_task_id;
        $assignment->assigned_emp_id = $request->assigned_emp_id;

        if ($assignment->save()) {
            // Count total employees assigned to the task
            $totalAssignedCount = AssignedEmployee::where('task_id', function ($query) use ($request) {
                $query->select('task_id')
                    ->from('assigned_emp')
                    ->where('id', $request->assigned_emp_id)
                    ->limit(1);
            })->count();

            $completedCount = InstanceTasksAssign::where('event_instance_task_id', $request->event_instance_task_id)
                ->count();

            // // If all assigned employees have completed the task, update task status to "Done"
            if ($totalAssignedCount == $completedCount) {
                $inst = EventInstanceTask::find($request->event_instance_task_id);
                if ($inst) {
                    $inst->status = 'Done';
                    // $inst->updated_at = 
                    $inst->save();
                } else {
                    dd('Task not found');
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Task status updated successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to update status.'
        ]);
    }

    public function edit($id)

    {
        $event = NewEvent::findOrFail($id);
        $coordinators = Employee::select('id', 'emp_name')->get();

        return response()->json([
            'event' => $event,
            'coordinators' => $coordinators
        ]);
    }

    // ✅ Update event after editing
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'sDate' => 'required|date',
            'eDate' => 'required|date|after_or_equal:sDate',
            'coordinatorID' => 'required|exists:employees,id'
        ]);

        $event = NewEvent::findOrFail($id);
        $event->start_date = $validated['sDate'];
        $event->end_date = $validated['eDate'];
        $event->coordinator = $validated['coordinatorID'];
        $event->save();

        return redirect()->back()->with('success', 'Event updated successfully!');
    }

    public function destroyEvent($id)
    {
        // Find the running event
        $event = NewEvent::findOrFail($id);
        $event->delete();

        return response()->json(['success' => true, 'message' => ' deleted successfully.']);
    }







    /* public static function edit($space_event_id)
    {
        $space_event = AnnualEvent::where('id', $space_event_id)
            ->get()
            ->first();
        $space_event_types = EventType::orderBy(
            'evetype_id',
            'ASC'
        )->paginate();
        $employees = Employee::orderBy('emp_id', 'ASC')->paginate();

        return view('space_event.space_event_edit', [
            'space_event' => $space_event,
            'space_event_types' => $space_event_types,
            'employees' => $employees,
        ]);
    }

    public function update($spaceEventId, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sDate' => 'required',
            'eDate' => 'required',
            'sp_event' => 'required',
            'coordinatorID' => 'required',
        ]);

        if ($validator->passes()) {
            AnnualEvent::where('id', $spaceEventId)->update([
                'start_date' => $request->sDate,
                'end_date' => $request->eDate,
                'coordinator_id' => $request->coordinatorID,
                'event_type_id' => $request->sp_event,
            ]);

            return redirect()
                ->route('space_event.index')
                ->with('success_updated', 'Employee edited successfully.');
        } else {
            return redirect()
                ->route('space_event.edit', $spaceEventId)
                ->withErrors($validator)
                ->withInput();
        }
    }

    public function delete($spaceEventId)
    {
        AnnualEvent::where('id', $spaceEventId)->delete();
        return redirect()
            ->route('space_event.index')
            ->with('delete_success', 'Space Event deleted successfully.');
    }

    // search events & category
    public function searchEvents_And_Types(Request $request)
    {
        if ($request->search) {
            $searchEvents_And_Types = AnnualEvent::where(
                'event_name',
                'LIKE',
                '%' . $request->search . '%'
            )
                ->latest()
                ->paginate(15);
            return view('components.searchbar');
        } else {
            return redirect()
                ->back()
                ->with('message', 'No search found');
        }
    } */
}
