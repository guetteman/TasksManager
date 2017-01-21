<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\App;


class TasksController extends Controller {

    protected $task;

    /**
     * TasksController constructor.
     * @param Task $task
     */
    public function __construct(Task $task) {
        $this->task = $task;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(){
        return $this->task->all();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){

        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'priority_id' => 'required|exists:priorities,id',
            'title'    => 'required|max:255',
            'description' => 'required|max:500',
            'due_date' => 'required|date',
        ]);

        $task = $this->task->store($request);

        return response()->json([
            'created' => true,
            'task' => $task
        ]);
    }

    /**
     * @param $id
     * @return \App\Task
     */
    public function show($id){
        $task = $this->task->getWith($id, ['user', 'priority']);

        if ($task->isEmpty()) {
            return response()->json(['task_not_found'], 404);
        }

        return $task;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id){

        $currentTask =$this->task->getById($id);

        if (empty($currentTask)){
            return response()->json(['task_not_found'], 404);
        }

        $this->validate($request, [
            'user_id' => 'exists:users,id',
            'priority_id' => 'exists:priorities,id',
            'title'    => 'max:255',
            'description' => 'max:500',
            'due_date' => 'date',
        ]);

        $newTask = $currentTask->modify($request);

        return response()->json([
            'updated' => true,
            'task' => $newTask
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        $task = $this->task->getById($id);

        if (empty($task)) {
            return response()->json(['task_not_found'], 404);
        }

        $task->erase();

        return response()->json([
            'deleted' => true,
        ]);
    }

}
