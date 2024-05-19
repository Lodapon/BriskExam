<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersCredit extends Model
{
    use HasFactory;

    protected $table = 'v_user_credit';
    const CREATED_AT = 'created_date';
    protected $dates = ['join_date'];
    protected $fillable = [
        'credit_id',
        'account_id',
        'user_cr',
        'created_by',
        'update_user',
        'balance_amt',
        'created_date',
        'email',
        'join_date',
        'role_name'
    ];
}
