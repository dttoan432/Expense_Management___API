<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    protected $fillable = [
        'code',
        'name',
        'description',
        'permission_group_code',
        'role_ids'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
