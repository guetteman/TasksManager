<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;


class UsersController extends Controller {

  protected $user;

  public function __construct(User $user) {
      $this->user = $user;
  }

  public function index(){
    return $this->user->all();
  }

  public function store(Request $request){

    $this->validate($request, [
        'email'    => 'required|email|max:255|unique:users,email',
        'password' => 'required|max:50',
        'first_name' => 'required|max:50',
        'last_name' => 'required|max:50',
        'role' => 'required|in:user,admin'
    ]);

    $user = $this->user->store($request);

    return redirect('admin/users/'.$user->id);
  }

  public function show($id){
    $user = $this->user->getById($id);

    if (is_null($user)) {
      return response()->json(['user_not_found'], 404);
    }

    $tasks = $user->tasks()->with('priority')->get();

    return response()->json([
      'user' => $user,
      'tasks' => $tasks
    ]);
  }

  public function update(Request $request, $id){

    $currentUser =$this->user->getById($id);

    if (is_null($currentUser)){
      return response()->json(['user_not_found'], 404);
    }

    $this->validate($request, [
        'email'    => 'email|max:255',
        'password' => 'max:50',
        'first_name' => 'max:50',
        'last_name' => 'max:50',
        'role' => 'in:user,admin'
    ]);

    $newUser = $currentUser->modify($request->except('token'));

    return redirect('admin/users/'.$newUser->id);
  }

  public function destroy($id){
    $user = $this->user->getById($id);

    if (is_null($user)) {
      return response()->json(['user_not_found'], 404);
    }

    return $user->erase();
  }

}
