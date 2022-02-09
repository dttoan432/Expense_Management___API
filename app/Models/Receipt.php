<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'phone',
        'address',
        'reason',
        'money',
        'transaction_form',
        'status',
        'option_value_id',
        'bank_account_id',
        'user_id_created',
        'user_accept_step_1',
        'accept_step_1_at',
        'user_accept_step_2',
        'accept_step_2_at',
        'user_accept_step_3',
        'accept_step_3_at',
        'invoice_image',
        'is_cancelled',
        'user_id_cancel',
        'reason_cancel',
        'cancel_at'
    ];

    public function optionValue() {
        return $this->belongsTo(OptionValue::class);
    }

    public function bankAccount() {
        return $this->belongsTo(BankAccount::class);
    }

    public function userCreated() {
        return $this->belongsTo(User::class, 'user_id_created', '_id');
    }

    public function userAcceptStep1() {
        return $this->belongsTo(User::class, 'user_accept_step_1', '_id');
    }

    public function userAcceptStep2() {
        return $this->belongsTo(User::class, 'user_accept_step_2', '_id');
    }

    public function userAcceptStep3() {
        return $this->belongsTo(User::class, 'user_accept_step_3', '_id');
    }

    public function userCancel() {
        return $this->belongsTo(User::class, 'user_id_cancel', '_id');
    }
}
