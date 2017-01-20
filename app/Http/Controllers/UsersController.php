<?php

namespace App\Http\Controllers;

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
        'email'    => 'required|email|max:255',
        'password' => 'required|max:50',
        'first_name' => 'required|max:50',
        'last_name' => 'required|max:50',
        'role' => 'required|in:user,admin'
    ]);

    return $this->user->store($request);
  }

  public function show($id){
    $user = $this->user->getById($id);

    if (is_null($user)) {
      return response()->json(['user_not_found'], 404);
    }

    return $this->user->getById($id);
  }

  public function update(Request $request, $id){

    $newUser =$this->user->getById($id);

    if (is_null($newUser)){
      return response()->json(['user_not_found'], 404);
    }

    $this->validate($request, [
        'email'    => 'email|max:255',
        'password' => 'max:50',
        'first_name' => 'max:50',
        'last_name' => 'max:50',
        'role' => 'in:user,admin'
    ]);

    return $newUser->modify($request);
  }

  public function destroy($id){
    $user = $this->user->getById($id);

    if (is_null($user)) {
      return response()->json(['user_not_found'], 404);
    }

    return $user->erase();
  }

}