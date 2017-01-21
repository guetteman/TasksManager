<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Task extends BaseModel{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'title','description','due_date'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priority() {
        return $this->belongsTo('App\Priority');
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $this->title = $request->get('title');
        $this->description = $request->get('description');
        $this->due_date = $request->get('due_date');
        $this->user_id = $request->get('user_id');
        $this->priority_id = $request->get('priority_id');

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
