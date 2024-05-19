<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = "exam_m_grade";

    protected $fillable = [
        "g_id",
        "g_name",
        "created_date",
        "created_by",
        "updated_date",
        "updated_by"
    ];

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
}
