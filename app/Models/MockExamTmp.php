<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockExamTmp extends Model
{
    protected $table = "mock_exam_tmp";

    protected $fillable = [
        "me_id",
        "me_sec",
        "me_choice_total",
        "me_choice",
        "me_write",
        "me_tags",
        "created_date",
        "created_by",
        "updated_date",
        "updated_by"
    ];

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
}
