<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Auth;

class DashboardController extends Controller {

    protected $user;

    public function __construct() {
        $this->user = Auth::user();
    }

    public function index(){
        $tasks = $this->user->tasks()->with('priority')->get();

        return response()->json([
            'user' => $this->user,
            'tasks' => $tasks,
        ]);
    }
}
