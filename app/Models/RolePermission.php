<?php
/********************************
Developer:Kai Lowe-Jones
University ID: 230234682
********************************/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolePermission extends Model
{
    use SoftDeletes;

    protected $table = 'role_permissions';

    protected $fillable = ['role_id', 'table_name', 'read', 'write', 'delete'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
