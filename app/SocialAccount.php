<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class SocialAccount extends Model
{
  protected $fillable = [
     'user_id','provider','provider_user_id'
  ];

  public function user(){
    return $this->belongsTo('App\User');
  }

}
