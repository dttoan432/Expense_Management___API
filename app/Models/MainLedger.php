<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'money',
        'transaction_form',
        'bank_account_id',
        'option_value_id'
    ];

    public function bankAccount() {
        return $this->belongsTo(BankAccount::class);
    }

    public function optionValue() {
        return $this->belongsTo(OptionValue::class);
    }
}
