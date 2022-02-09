<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'option_code',
    ];

    public function option() {
        return $this->belongsTo(Option::class, 'option_code', 'code');
    }

    public function mainLedgers() {
        return $this->hasMany(MainLedger::class);
    }

    public function receipts() {
        return $this->hasMany(Receipt::class);
    }

    public function payments() {
        return $this->hasMany(Receipt::class);
    }
}
