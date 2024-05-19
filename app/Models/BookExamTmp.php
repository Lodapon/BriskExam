<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookExamTmp extends Model
{
    protected $table = "book_exam_tmp";

    protected $fillable = [
        "be_id",
        "be_sec",
        "be_choice_total",
        "be_choice",
        "be_write",
        "be_tags",
        "created_date",
        "created_by",
        "updated_date",
        "updated_by"
    ];

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
}
