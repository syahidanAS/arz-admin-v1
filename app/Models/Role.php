<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Role extends Model
{
    use HasFactory, HasRoles;
    protected $table = "roles";
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'guard_name',
        'desc'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }

    public function roleHasPermissions()
    {
        return $this->hasMany(RoleHasPermisssions::class, 'role_id', 'id');
    }
}
