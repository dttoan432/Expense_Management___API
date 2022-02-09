<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'account_number',
        'account_balance',
        'bank_branch',
        'bank_name'
    ];

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
