<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockExamDet extends Model
{
    protected $table = "mock_exam_det";

    protected $fillable = [
        "me_det_id",
        "me_que",
        "me_soln",
        "me_no_ans",
        "lv_id",
        "me_tags",
        "me_type",
        "created_date",
        "created_by",
        "updated_date",
        "updated_by"
    ];

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
}
