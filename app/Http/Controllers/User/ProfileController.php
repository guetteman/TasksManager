<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller {

    protected $user;

    public function __construct() {
        $this->user = Auth::user();
    }

    public function show(){
        return $this->user;
    }

    public function update(Request $request){

        $this->validate($request, [
            'email'    => 'email|max:255',
            'password' => 'max:50',
            'first_name' => 'max:50',
            'last_name' => 'max:50',
            'role' => 'in:user,admin'
        ]);

        $this->user->modify($request->except('role','password','token','_method'));

        return redirect('dashboard/users/'.$this->user->id);
    }

    public function destroy(){

        return $this->user->erase();
    }
}
