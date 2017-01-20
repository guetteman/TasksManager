<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model{

  public function getById($id){
    return $this->find($id);
  }

}
