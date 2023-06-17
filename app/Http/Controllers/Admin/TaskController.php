<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\API\TaskStoreRequest;
use App\Models\Task;
use App\Models\User;
use App\Http\Resources\TaskResource;
use App\Http\Requests\API\TaskUpdateRequest;
use App\Http\Requests\API\AttachTaskRequest;
use App\Http\Requests\API\DetachTaskRequest;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Mail;
use App\Mail\NotifyMail;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json([
            'message' => 'success',
            'data' => TaskResource::collection(Task::All())
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(TaskStoreRequest $request)
    {
        $task = Task::create([
            'title' => $request->title,
            'body' => $request->body,
            'is_done' => $request->is_done,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at
        ]);

        return response()->json([
            'message' => 'success',
            'data' => TaskResource::make($task)
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function show(Task $task)
    {
        return response()->json([
            'message' => 'success',
            'data' => TaskResource::make($task)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskUpdateRequest $request
     * @param Task $task
     * @return JsonResponse
     */
    public function update(TaskUpdateRequest $request, Task $task)
    {
        $task->update($request->all());
        return response()->json([
            'message' => 'success',
            'data' => TaskResource::make($task)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json([
            'message' => 'success',
        ], 200);
    }

    public function attach(AttachTaskRequest $request)
    {
        foreach($request->users as $user){
            $user = User::findOrFail($user);
            
            $user->tasks()->detach($request->get('tasks'));
            $user->tasks()->attach($request->get('tasks'), [
                'assigned_at'=> $request->get('assigned_at')??Carbon::now(),
                'is_done' => $request->get('is_done')??0
            ]);
        }

        return response()->json([
            'message' => 'success',
        ], 200);
    }

    public function detach(DetachTaskRequest $request)
    {
        foreach($request->users as $user){
            User::findOrFail($user)->tasks()->detach($request->get('tasks'));
        }

        return response()->json([
            'message' => 'success',
        ], 200);
    }
}
