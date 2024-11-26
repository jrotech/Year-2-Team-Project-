<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Matching\SchemeValidator;

class Role extends Model
{
  protected $fillable = ['name']; //assignable attributes

  public function users()
  {
    return $this->hasMany(User::class, 'role_id');
  }

  public function permissions()
  {
    return $this->hasMany(RolePermission::class, 'role_id');
  }
}
