<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    
    protected $table = "exam_m_sub";

    protected $fillable = [
        "sub_id",
        "sub_name",
        "created_date",
        "created_by",
        "updated_date",
        "updated_by"
    ];

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';

    public function fixexam()
    {
        return $this->belongsTo(FixExamTemplate::class, 'sub_id');
    }
}
