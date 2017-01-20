<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Http\Request;

class User extends BaseModel implements JWTSubject, AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function tasks() {

      return $this->hasMany('App\Task');

    }

    public function getJWTIdentifier() {

        return $this->getKey();

    }

    public function getJWTCustomClaims() {

        return [];

    }

    public function store(Request $request){
      $this->first_name = $request->get('first_name');
      $this->last_name = $request->get('last_name');
      $this->email = $request->get('email');
      $this->role = $request->get('role');
      $this->password = app('hash')->make($request->get('password'));

      if(!$this->save()){
        return response()->json(['server_error'], 500);
      }
      return $this;
    }

    public function modify($request){
      foreach ($request as $key => $value) {
        $this[$key] = $value;
      }

      if(!$this->update()){
        return response()->json(['server_error'], 500);
      }
      return $this;
    }

    public function erase(){
      if(!$this->delete()){
        return response()->json(['server_error'], 500);
      }

      return response()->json(['user_deleted'], 200);
    }

}
