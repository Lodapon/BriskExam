<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamHist extends Model
{
    use HasFactory;

    protected $table = 'v_exam_hist';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
    protected $fillable = [
        'ex_id',
        'account_id',
        'ex_point',
        'ex_dev_point',
        'ex_status',
        'ex_time',
        'created_date',
        'updated_date',
        'total_time',
        'ex_name',
    ];
}
