<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\EventType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SpaceEventTypeController extends Controller
{
    public function index()
    {
        return view('pages.space_event_type.space_event_type_list');
    }
    /**
     *returns the view of relevent tasks for the selected event
     * @param mixed $event fetch selected event id
     * @return view view of relevent tasks for the selected event
     * @author Hansana Sandeepa <hansana.s.somarathna@gmail.com>
     */
    public function showTasks($event)
    {
        $tasks = Task::where('event_type_id', $event)->get();
        $event = EventType::where('id', $event)->first();

        return view(
            'pages.task.tasks_per_event',
            [
                'tasks' => $tasks,
                'event' => $event
            ]
        );
    }

    /**
     * Fetches all event types from the database and generates a HTML table for display.
     *
     * @return void
     *
     * @author Hansana Sandeepa <hansana.s.somarathna@gmail.com>
     */
    public function fetchAll()
    {
        $eventTypes = EventType::all();
        $output = '';
        if ($eventTypes->count() > 0) {
            $output .= '<table class="table table-striped align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Event Type</th>
                <th>Image</th>
                <th>Action</th>
                <th>Tasks</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($eventTypes as $key => $eventType) {
                $img_path = $eventType->img_path;
                $imgPath = asset('storage/' . $img_path);
                $output .= '<tr>
                <td>' . ++$key . '</td>
                <td>' . $eventType->event_type . '</td>
                <td>
                    <a href="#" id="' . $eventType->id . '" class="btn btn-success btn-sm mx-1 imageIcon" title="show image" onclick-="showImage(\'' . $eventType->id . '\')"><i class="bx bx-image" style="font-size: 22px"></i></a>
                </td>
                <td>
                  <a href="#" id="' . $eventType->id . '" class="btn btn-primary btn-sm mx-1 editIcon" data-bs-target="#editEventTypeModel" title="edit"><i class="bx bx-edit"style="font-size: 22px" ></i></a>
                  <a href="#" id="' . $eventType->id . '" class="btn btn-danger btn-sm mx-1 deleteIcon" title="delete"><i class="bx bxs-trash" style="font-size: 22px"></i></a>
                </td>
                <td>
                    <a href="/event_type/tasks/' . $eventType->id . '" class="btn btn-success rounded">View Tasks</a>
                    <input type="hidden" name="imgPath[]" id="imgPath_' . $eventType->id . '" value="' . $imgPath . '">
                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h4 class="text-center text-secondary my-5">No record in the database!</h4>';
        }
    }

    /**
     * use to retrieve dedicated image for the event type
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @author Hansana Sandeepa <hansana.s.somarathna@gmail.com>
     */

    // $eventType = EventType::where('id', $id)->first();
    // return response()->json(['image_path' => $eventType->img_path]);

    /**
     * use to store initial event types
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @author Hansana Sandeepa <hansana.s.somarathna@gmail.com>
     */
    public function store(Request $request)
    {
        $value = $request->event_type;

        // DB එකේ duplicate check
        $existInData = EventType::where('event_type', $value)->first();
        if ($existInData) {
            return response()->json([
                'success' => false,
                'message' => $value . ' already exists in the database',
                'title' => 'Found Duplicate',
                'type' => 'info'
            ]);
        }

        // Default image path
        $img_path = 'ini_events_images/default.jpg';

        if ($request->hasFile('image')) {
            // File validate
            $validator = Validator::make($request->all(), [
                'image' => 'mimes:jpg,jpeg,png,webp,gif,svg|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'title' => 'Unauthorized file Type',
                    'type' => 'error'
                ]);
            }

            // Image upload (save to storage/app/public/ini_events_images/uploads)
            $img_path = $request->file('image')->store('ini_events_images/uploads', 'public');
        }

        // Save DB
        $newRecord = EventType::create([
            'event_type' => $value,
            'img_path'   => $img_path
        ]);

        return response()->json([
            'success'     => true,
            'message'     => 'Event type added successfully',
            'title'       => 'Saved!',
            'type'        => 'success',
            'new_record'  => $newRecord->id
        ]);
    }

    public function showImage(Request $request)
    {
        $eventType = EventType::findOrFail($request->id);

        // Full URL generate
        $imageUrl = asset('storage/' . $eventType->img_path);

        return response()->json([
            'image_path' => $imageUrl
        ]);
    }

    /**
     * Updates an existing event type in the database.
     *
     * @param Request $request The incoming request containing the necessary data for updating the event type.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the success or failure of the operation.
     *
     * @author Hansana Sandeepa <hansana.s.somarathna@gmail.com>
     */
    public function update(Request $request)
    {
        $event_type = EventType::find($request->event_id);
        $original_value = $request->original_event_type;
        $value = $request->edit_event_type;

        $existInData = EventType::where('event_type', $value)->first();

        //check if the event type has changed
        if ($original_value !== $value) {
            //check if the value already exists in the database
            if ($existInData) {
                return response()->json([
                    'success' => false,
                    'message' => $value . ' already exists in the database',
                    'title' => 'Found Duplicate',
                    'type' => 'info'
                ]);
            }
        }
        //check weather the user input a file
        if ($request->file()) {
            $file_path = $existInData->img_path;

            //delete the previous image if exists
            if ($file_path != 'ini_events_images/default.jpg') {
                Storage::delete('public/' . $file_path);
                Log::info('Image Deleted');
            }
            //file validate
            $validator = Validator::make($request->all(), [
                'edit_event_type_image' => 'mimes:jpg,jpeg,png,webp,gif,svg'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'title' => 'Unauthorized file Type',
                    'type' => 'error'
                ]);
            }

            //image upload
            $img_path = $request->file('edit_event_type_image')->store('ini_events_images/uploads', 'public');

            $update_data = [
                'event_type' => $request->edit_event_type,
                'img_path' => $img_path,
                'updated_at' => Carbon::now()
            ];
        } else {
            $update_data = [
                'event_type' => $request->edit_event_type,
                'updated_at' => Carbon::now()
            ];
        }

        $event_type->update($update_data);
        return response()->json([
            'success' => true,
            'message' => 'Event type updated successfully',
            'title' => 'Updated!',
            'type' => 'success'
        ]);
    }

    /*
     * delete selected event type and dedicated images from the database
     *
     * @param Request $request
     * @author Hansana Sandeepa <hansana.s.somarathna@gmail.com>
     */
    public function delete(Request $request)
    {
        $id = $request->id;

        //check weather an event type has tasks
        $taskCount = Task::where('event_type_id', $id)->count();
        if ($taskCount > 0) {
            return response()->json(['success' => false, 'title' => 'Error', 'message' => 'This Event type has related tasks. Delete the tasks first before deleting the event type.', 'type' => 'error']);
        }

        //delete dedicated image from the event type
        $event = EventType::find($id);
        $img_path = $event->img_path;
        if ($img_path != 'ini_events_images/default.jpg') {
            Storage::delete('public/' . $img_path);
            Log::info('Image Deleted');
        }
        //delete the event type from the database
        EventType::destroy($id);
        return response()->json(['success' => true]);
    }
}
