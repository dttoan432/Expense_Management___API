<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];

    public function optionValues() {
        return $this->hasMany(OptionValue::class, 'option_code', 'code');
    }
}
