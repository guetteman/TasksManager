<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model{

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name'
  ];

  public function tasks() {

    return $this->hasMany('App\Task');

  }
}
