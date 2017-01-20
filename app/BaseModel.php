<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model{

  public function getById($id){
    return $this->find($id);
  }

  public function erase(){
    if(!$this->delete()){
      return response()->json(['server_error'], 500);
    }

    return response()->json(['delete_successful'], 200);
  }

}
