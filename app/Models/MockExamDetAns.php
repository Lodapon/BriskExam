<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockExamDetAns extends Model
{
    protected $table = "mock_exam_det_ans";

    protected $fillable = [
        "me_det_id",
        "me_ans",
        "me_ans_no",
        "created_date",
        "created_by",
        "updated_date",
        "updated_by",
    ];

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
}
