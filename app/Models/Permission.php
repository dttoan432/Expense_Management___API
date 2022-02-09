<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'permission_group_code',
        'role_ids'
    ];

    public function role() {
        return $this->belongsToMany(Role::class);
    }

    public function permissionGroup() {
        return $this->belongsTo(PermissionGroup::class, 'permission_group_code', 'code');
    }
}
