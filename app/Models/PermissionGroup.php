<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class PermissionGroup extends Model
{
    use HasFactory;

    protected $table = 'permission_groups';

    protected $fillable = [
        'name',
        'description',
        'code',
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'permission_group_code', 'code');
    }
}
