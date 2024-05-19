<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewCreatorTran extends Model
{
    use HasFactory;

    protected $table = 'v_crt_pur_db';
    const CREATED_AT = 'created_date';
    protected $fillable = [
        'pur_id',
        'account_id',
        'user_exam',
        'role',
        'user_type',
        'prod_name',
        'created_date',
        'created_by',
        'exam_created',
        'price',
    ];
}
