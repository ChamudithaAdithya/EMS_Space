<?php
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Eventformcontroller;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SpaceEventTypeController;
use App\Http\Controllers\AnnualEventController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AssignedEmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\SpaceEventCreateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// @ DESCRIPTION      => SpaceEventCreateController,HelpController,CertificateController,InvitationController
// @ ENDPOINT         => Views
// @ ACCESS           => all members in space section
// @ CREATED BY       => Harindu Ashen
// @ CREATED DATE     => 2024/06/26
// @ CHANGED BY       => Hansana Sandeepa

//Login
Route::get('/',[AuthController::class, "login"]);
Route::post('/login',[AuthController::class, "AuthLogin"]);
Route::get('/logout',[AuthController::class, "logout"]);
// Route::get('/forgot-password',[AuthController::class, "forgotpassword"]);
// Route::post('/forgot-password',[AdminController::class, "PostForgotPassword"]);

//admin
Route::get('admin/dashboard', [DashboardController::class,'index'])->name('space_event.dashboard');
//Route::get('admin/dashboard',[AnnualEventController::class, 'upcomingEvents'])->name('space_event.dashboard');
Route::get('admin/profile',[ProfileController::class, 'profile'])->name('user_profile.profile');
Route::get('admin/settings',[SettingsController::class, 'settings'])->name('user_profile.settings');
Route::post('admin/settings/changeUserEmail',[SettingsController::class, 'changeUserEmail'])->name('user_profile.settings.changeUserEmail');
Route::post('admin/settings/changeUserPassword',[SettingsController::class, 'changeUserPassword'])->name('user_profile.settings.changeUserPassword');
Route::get('admin/dashboard/view',[AnnualEventController::class, 'upcomingEventsView'])->name('upcoming_event.view');

//create help route harindu
Route::get('admin/help',[HelpController::class,'help'])->name('Help.helpDoc');


/*-- ANNUAL EVENT INSTANCES --*/
// Route::get('/space_events',[AnnualEventController::class,'index'])->name('space_event.index');

// View Events by feedback version
Route::get('/space_events',[AnnualEventController::class,'index1'])->name('space_event.index1');
Route::get('/space_event/create', [AnnualEventController::class, 'createEvent'])->name('space_event.create');

Route::get('/space_event/view', [AnnualEventController::class, 'viewEvent'])->name('space_event.view');
Route::get('/space_event/view/{event_id}', [AnnualEventController::class, 'viewEventById']);

//show completed and runnig events
Route::get('/space_event/completedEvents/{eventTypeId}', [AnnualEventController::class, 'completedEvents'])->name('space_event.completedEvents');
Route::get('/space_event/completedEvents/completedEvent/{eventTypeId}', [AnnualEventController::class, 'completedEvent'])->name('space_event.completedEvents.completedEvent');
Route::get('/space_event/runnigEvent/{eventTypeId}', [AnnualEventController::class, 'runnigEvent'])->name('space_event.runnigEvent');
Route::get('/space_event/runnigEvents/{newEventId}', [AnnualEventController::class, 'runnigEvents'])->name('space_event.runnigEvents');    //used when there are MULTIPLE RUNNING EVENTS present in the same event type

// Route::post('/instance-task-assign/update-status', [AnnualEventController::class, 'updateTaskAssignStatus'])->name('instance_task_assign.updateStatus');
Route::post('/update-task-status', [AnnualEventController::class, 'updateTaskAssignStatus']);
// Route::post('/update-organizing-details', [AnnualEventController::class, 'updateOrganizingDetails'])->name('events.updateOrganizingDetails');
Route::get('/running-event/{id}/edit', [AnnualEventController::class, 'edit']);
Route::post('/rueventnning-/{id}/update', [AnnualEventController::class, 'update'])->name('running-event.update');


// create->form change into a modal
//Route::get('/space_events/create',[AnnualEventController::class,'create'])->name('space_event.create');
Route::post('/space_events/assignemployee', [AnnualEventController::class, 'assignEmployee'])->name('assign.employee');
Route::post('/space_events/store',[AnnualEventController::class,'store'])->name('space_event.store');
// Only one delete route for space_event
// Route::delete('/space_events/delete/{id}', [AnnualEventController::class, 'destroy'])->name('space_event.delete');
Route::delete('/space_events/delete/{id}', [AnnualEventController::class, 'destroyEvent'])->name('space_event.destroyEvent');






//Pass data and tasks list to creating an event
Route::post('/space_events/insertEventData',[AnnualEventController::class,'insertEventData'])->name('space_event.insertEventData');

//View Reports list
Route::get('/space_events/{event_id}',[AnnualEventController::class,'show'])->name('space_event.show');
Route::get('/admin/invitations',[InvitationController::class,'invitation'])->name('reports.invitations');
Route::get('/download-pdf', [PdfController::class, 'downloadPdf']);



// View Created event report
Route::get('/space_events/{eventTypeId}/Report', [AnnualEventController::class, 'Report'])->name('space_event.editReport');
//Route::get('/space_events/{space_event}/edit',[AnnualEventController::class,'edit'])->name('space_event.edit');
Route::put('/space_events/{space_event}/update',[AnnualEventController::class,'update'])->name('space_event.update');
Route::delete('/space_events/{employee}/delete',[AnnualEventController::class,'delete'])->name('space_event.delete');
Route::get('/space_events/get_employees', [AnnualEventController::class, 'getEmployees'])->name('get.employees');
Route::post('/space_events/status',[AnnualEventController::class, 'status'])->name('update.task.status');
/* End of ANNUAL EVENT INSTANCES */


//Space Event Type List
Route::prefix('event_type')->group(function (){
    Route::get('/',[SpaceEventTypeController::class,'index'])->name('event_type.index');
    Route::post('/store',[SpaceEventTypeController::class,'store'])->name('event_type.store');
    Route::get('/fetch_all',[SpaceEventTypeController::class,'fetchAll'])->name('event_type.fetchAll');
    Route::delete('/delete',[SpaceEventTypeController::class,'delete'])->name('event_type.delete');
    Route::get('/edit',[SpaceEventTypeController::class,'edit'])->name('event_type.edit');
    Route::post('/update',[SpaceEventTypeController::class,'update'])->name('event_type.update');
    Route::get('/tasks/{event}',[SpaceEventTypeController::class,'showTasks'])->name('event_type.index');
    Route::get('/showImage',[SpaceEventTypeController::class,'showImage'])->name('event_type.showImage');
});

//page create by diuth induwara
Route::get('/eventform',[Eventformcontroller::class,'event'])->name('space.event_type.space_event_form');


//create new event harindu have to change
Route ::prefix('event_create')->group(function(){
    Route::get('/',[SpaceEventCreateController::class,'index'])->name('event_create.index');
    //Route::post('/store',[SpaceEventCreateController::class,'store'])->name('event_create.store');
    /* Route::get('/fetch_all',[SpaceEventCreateController::class,'fetchAll'])->name('event_type.fetchAll');
    Route::delete('/delete',[SpaceEventCreateController::class,'delete'])->name('event_type.delete');
    Route::get('/edit',[SpaceEventCreateController::class,'edit'])->name('event_type.edit');
    Route::post('/update',[SpaceEventCreateController::class,'update'])->name('event_type.update'); */
});

//Employees
Route::get('/employees',[EmployeeController::class,'index'])->name('employee.index');
Route::get('/employees/create',[EmployeeController::class,'create'])->name('employee.create');
Route::post('/employees/store',[EmployeeController::class,'store'])->name('employee.store');
Route::get('/employees/fetch_all',[EmployeeController::class,'fetchAll'])->name('employee.fetchAll');
Route::get('/employees/edit',[EmployeeController::class,'edit'])->name('employee.edit');
Route::post('/employees/update',[EmployeeController::class,'update'])->name('employee.update');
Route::delete('/employees/delete',[EmployeeController::class,'delete'])->name('employee.delete');


//Assigned Employee

Route::get('/assgn_employees',[AssignedEmployeeController::class,'index'])->name('assgn_employee.index');
//Route::post('/assgn_employees/store', [AssignedEmployeeController::class, 'store'])->name('assgn_employees.store');
// Route::post('/ajax/gettaskbyevent/{eventId}', [AssignedEmployeeController::class, 'gettaskbyevent'])->name('gettaskbyevent');
Route::post('/assgn_employees/store', [AssignedEmployeeController::class, 'store'])->name('assgn_employees.store');
Route::get('/get-task-by-event/{event_id}', [AssignedEmployeeController::class, 'getTaskByEvent']);
Route::get('/ajax/gettaskbyevent/{eventId}', [AssignedEmployeeController::class, 'gettaskbyevent']);
Route::get('/ajax/getemployee', [EmployeeController::class, 'getemployee']);
Route::get('/assgn_employees/edit/{id}', [AssignedEmployeeController::class, 'edit'])->name('assgn_employees.edit');
Route::post('/assgn_employees/update/{id}', [AssignedEmployeeController::class, 'update'])->name('assgn_employees.update');
Route::delete('/assgn_employees/delete/{id}', [AssignedEmployeeController::class, 'destroy'])->name('assgn_employees.destroy');




//Tasks
Route::prefix('task')->group(function (){
    Route::get('/',[TaskController::class,'index'])->name('task.index');
    Route::post('/store',[TaskController::class,'store'])->name('task.store');
    Route::get('/fetch_tasks/{id}',[TaskController::class,'fetchTasks'])->name('task.fetchTasks');
    Route::get('/edit',[TaskController::class,'edit'])->name('task.edit');
    Route::post('/get-tasks-by-event',[TaskController::class,'getTasksByEvent'])->name('task.getTasksByEvent');
    Route::post('/update',[TaskController::class,'update'])->name('task.update');
    Route::post('/addAttachment',[TaskController::class,'addAttachment'])->name('task.addAttachment');
    Route::get('/downloadAttachment',[TaskController::class,'downloadAttachment'])->name('task.downloadAttachment');
    Route::delete('/deleteAttachment',[TaskController::class, 'deleteAttachment'])->name('task.deleteAttachment');;
    Route::delete('/deleteTask',[TaskController::class,'deleteTask'])->name('task.deleteTask');
});



Route::prefix('reports')->group(function(){
    Route::get('/registeredlist', [EventController::class, 'showRegisteredList'])->name('reports.showRegisteredList');
    Route::post('/form-data', [EventController::class, 'store'])->name('reports.store');
    Route::post('/import', [EventController::class, 'import'])->name('reports.import');
    Route::delete('/delete/{id}',[EventController::class,'delete'])->name('reports.delete');
    Route::get('/fetch_all',[EventController::class,'fetchAll'])->name('reports.fetchAll');
    Route::post('/update', [EventController::class, 'update'])->name('reports.update');
    Route::post('/send', [EmailController::class, 'sendemail'])->name('send.email');
     //Harindu 2024/07/04
});


//uploads
Route::post('/upload', function (Request $request) {
    $request->validate([
        'file' => 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:2048', // 2MB limit
    ]);

    // Store in public/uploads
    $file = $request->file('file');
    $filename = time() . '-' . $file->getClientOriginalName();
    $file->move(public_path('uploads'), $filename);

    return back()->with('success', 'File uploaded successfully!');
});

Route::get('/upload', function () {
    return view('upload'); // This will load upload.blade.php
});    