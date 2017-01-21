<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Task;
use App\Priority;
use App\User;


class AdminController extends Controller {

    protected $task;
    protected $user;
    protected $priority;

    /**
     * AdminController constructor.
     * @param Task $task
     * @param User $user
     * @param Priority $priority
     */
    public function __construct(Task $task, User $user, Priority $priority) {
        $this->task = $task;
        $this->user = $user;
        $this->priority = $priority;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $users = $this->user->all();
        $tasks = $this->task->all();
        $priorities = $this->priority->all();

        return response()->json([
            'users' => $users,
            'tasks' => $tasks,
            'priorities' => $priorities
        ]);
    }

}
