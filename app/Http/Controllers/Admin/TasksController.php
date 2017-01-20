<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Task;


class TasksController extends Controller {

  protected $task;

  public function __construct(Task $task) {
      $this->task = $task;
  }

  public function index(){
    return $this->task->all();
  }

  public function store(Request $request){

    $this->validate($request, [
        'user_id' => 'required|exists:users,id',
        'priority_id' => 'required|exists:priorities,id',
        'title'    => 'required|max:255',
        'description' => 'required|max:500',
        'due_date' => 'required|date',
    ]);

    $task = $this->task->store($request);

    return redirect('admin/tasks/'.$task->id);
  }

  public function show($id){
    $task = $this->task->getWith($id, ['user', 'priority']);

    if (is_null($task)) {
      return response()->json(['task_not_found'], 404);
    }

    return $task;
  }

  public function update(Request $request, $id){

    $currentTask =$this->task->getById($id);

    if (is_null($currentTask)){
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

    return redirect('admin/tasks/'.$newTask->id);
  }

  public function destroy($id){
    $task = $this->task->getById($id);

    if (is_null($task)) {
      return response()->json(['task_not_found'], 404);
    }

    return $task->erase();
  }

}
