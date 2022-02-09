<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'target_table_name',
        'target_id',
        'code'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
