<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller {

    protected $user;

    /**
     * ProfileController constructor.
     */
    public function __construct() {
        $this->user = Auth::user();
    }

    /**
     * @return \App\User
     */
    public function show(){
        return $this->user;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request){

        $this->validate($request, [
            'email'    => 'email|max:255',
            'password' => 'max:50',
            'first_name' => 'max:50',
            'last_name' => 'max:50',
            'role' => 'in:user,admin'
        ]);

        $user = $this->user->modify($request->except('role','password','token','_method'));

        return response()->json([
            'updated' => true,
            'user' => $user
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(){

        $this->user->erase();

        return response()->json([
            'deleted' => true,
        ]);
    }
}
