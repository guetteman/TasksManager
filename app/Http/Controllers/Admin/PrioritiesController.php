<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Priority;


class PrioritiesController extends Controller {

    protected $priority;

    /**
     * PrioritiesController constructor.
     * @param Priority $priority
     */
    public function __construct(Priority $priority) {
        $this->priority = $priority;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(){
        return $this->priority->all();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){

        $this->validate($request, [
            'name' => 'required|max:20',
        ]);

        $priority = $this->priority->store($request);

        return response()->json([
            'created' => true,
            'priority' => $priority
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id){
        $priority = $this->priority->getById($id);

        if (empty($priority)) {
            return response()->json(['priority_not_found'], 404);
        }

        $tasks = $priority->tasks()->with('user')->get();

        return response()->json([
            'priority' => $priority,
            'tasks' => $tasks
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id){

        $currentPriority =$this->priority->getById($id);

        if (empty($currentPriority)){
            return response()->json(['priority_not_found'], 404);
        }

        $this->validate($request, [
            'name'    => 'max:20',
        ]);

        $newPriority = $currentPriority->modify($request);

        return response()->json([
            'updated' => true,
            'priority' => $newPriority
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        $priority = $this->priority->getById($id);

        if (empty($priority)) {
            return response()->json(['priority_not_found'], 404);
        }

        $priority->erase();

        return response()->json([
            'deleted' => true,
        ]);
    }

}
