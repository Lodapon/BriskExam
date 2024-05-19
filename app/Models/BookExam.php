<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookExam extends Model
{
    protected $table = "book_exam";

    protected $fillable = [
        "be_id",
        "sub_id",
        "mx_id",
        "be_price",
        "be_time",
        "be_status",
        "created_date",
        "created_by",
        "updated_date",
        "updated_by"
    ];

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
}
