<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Priority extends BaseModel{

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks() {
        return $this->hasMany('App\Task');
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $this->name = $request->get('name');

        if(!$this->save()){
            return response()->json(['server_error'], 500);
        }

        return $this;
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function modify(Request $request){

        foreach ($request->except('token','_method') as $key => $value) {
            $this[$key] = $value;
        }

        if(!$this->update()){
            return response()->json(['server_error'], 500);
        }

        return $this;
    }
}
