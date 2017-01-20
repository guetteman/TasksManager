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

    return $this->priority->store($request);
  }

  public function show($id){
    $priority = $this->priority->getById($id);

    if (is_null($priority)) {
      return response()->json(['priority_not_found'], 404);
    }

    return $this->priority->getById($id);
  }

  public function update(Request $request, $id){

    $newPriority =$this->priority->getById($id);

    if (is_null($newPriority)){
      return response()->json(['priority_not_found'], 404);
    }

    $this->validate($request, [
      'name'    => 'max:20',
    ]);

    return $newPriority->modify($request);
  }

  public function destroy($id){
    $priority = $this->priority->getById($id);

    if (is_null($priority)) {
      return response()->json(['priority_not_found'], 404);
    }

    return $priority->erase();
  }

}
