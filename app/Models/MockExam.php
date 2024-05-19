<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockExam extends Model
{
    protected $table = "mock_exam";

    protected $fillable = [
        "me_id",
        "sub_id",
        "mx_id",
        "me_price",
        "me_time",
        "me_status",
        "created_date",
        "created_by",
        "updated_date",
        "updated_by"
    ];

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
}
