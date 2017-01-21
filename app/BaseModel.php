<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model{

    /**
     * @param $id
     * @return $this
     */
    public function getById($id){
        return $this->find($id);
    }

    /**
     * @param $id
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public function getWith($id, array $relations){
        return $this->with($relations)->find($id);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function erase(){
        if(!$this->delete()){
            return response()->json(['server_error'], 500);
        }

        return response()->json(['delete_successful'], 200);
    }

}
