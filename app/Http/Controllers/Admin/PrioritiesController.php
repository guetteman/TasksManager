<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Priority;


class PrioritiesController extends Controller {

  protected $priority;

  public function __construct(Priority $priority) {
      $this->priority = $priority;
  }

  public function index(){
    return $this->priority->all();
  }

  public function store(Request $request){

    $this->validate($request, [
        'name' => 'required|max:20',
    ]);

    $priority = $this->priority->store($request);

    return redirect('admin/priorities/'.$priority->id);
  }

  public function show($id){
    $priority = $this->priority->getById($id);

    if ($priority->isEmpty()) {
      return response()->json(['priority_not_found'], 404);
    }

    $tasks = $priority->tasks()->with('user')->get();

    return response()->json([
      'priority' => $priority,
      'tasks' => $tasks
    ]);
  }

  public function update(Request $request, $id){

    $currentPriority =$this->priority->getById($id);

    if ($currentPriority->isEmpty()){
      return response()->json(['priority_not_found'], 404);
    }

    $this->validate($request, [
      'name'    => 'max:20',
    ]);

    $newPriority = $currentPriority->modify($request);

    return redirect('admin/priorities/'.$newPriority->id);
  }

  public function destroy($id){
    $priority = $this->priority->getById($id);

    if ($priority->isEmpty()) {
      return response()->json(['priority_not_found'], 404);
    }

    return $priority->erase();
  }

}
