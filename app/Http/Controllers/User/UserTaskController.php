<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Http\Resources\OnlyTaskResource;
use App\Http\Requests\API\UserTaskUpdateRequest;
use App\Models\Task;

class UserTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return auth()->user();
        return response()->json([
            'message' => 'success',
            'data' => OnlyTaskResource::collection(auth()->user()->tasks)
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $task = auth()->user()->tasks->where('id', $id)->first();
        if($task){
            return response()->json([
                'message' => 'success',
                'data' => OnlyTaskResource::make($task)
            ], 200);
        }else{
            return response()->json([
                'message' => 'not found',
            ], 404);
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserTaskUpdateRequest $request, Task $task)
    {
        $task = auth()->user()->tasks->where('id', $task->id)->first();
        if($task){
            $task->pivot->update([
                'is_done' => $request->is_done
            ]);

            return response()->json([
                'message' => 'success',
                'data' => OnlyTaskResource::make($task)
            ], 200);

        }else{
            return response()->json([
                'message' => 'not allowed',
            ], 405);
        }
    }
}
