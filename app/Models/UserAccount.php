<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    use HasFactory;

    protected $table = 'user_account';
    protected $primaryKey = 'account_id';

    protected $fillable = [
        'account_id',
        'username',
        'password',
        'salt',
        'role',
        'status',
        'email',
        'created_date',
        "updated_date",
    ];

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
}
