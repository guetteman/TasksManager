<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Task;
use Auth;


class TaskController extends Controller {

    protected $task;
    protected $user;

    public function __construct(Task $task) {
        $this->user = Auth::user();
        $this->task = $task;
    }

    public function index(){
        return $this->user->tasks()->get();
    }

    public function store(Request $request){

        $this->validate($request, [
            'user_id' => 'required',
            'priority_id' => 'required|exists:priorities,id',
            'title'    => 'required|max:255',
            'description' => 'required|max:500',
            'due_date' => 'required|date',
        ]);

        if ($request->get('user_id') != $this->user->id) {
            return response()->json(['wrong user_id']);
        }

        $task = $this->task->store($request);

        return redirect('dashboard/tasks/' . $task->id);
    }

    public function show($id){

        $task = $this->user->tasks()->where('id', $id)->with('priority')->first();

        if (empty($task)) {
            return response()->json(['task_not_found'], 404);
        }

        return $task;
    }

    public function update(Request $request, $id){

        $currentTask = $this->user->tasks()->where('id', $id)->with('priority')->first();

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

        if ($request->get('user_id') != $this->user->id) {
            return response()->json(['wrong user_id']);
        }

        $newTask = $currentTask->modify($request);

        return redirect('dashboard/tasks/'.$newTask->id);
    }

    public function destroy($id){
        $task = $this->user->tasks()->where('id', $id)->with('priority')->first();

        if (empty($task)) {
            return response()->json(['task_not_found'], 404);
        }

        return $task->erase();
    }

}
