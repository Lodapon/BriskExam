<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockUpName extends Model
{
    use HasFactory;
    
    protected $table = "exam_mx_name";

    protected $fillable = [
        "mx_id",
        "mx_name",
        "created_date",
        "created_by",
        "updated_date",
        "updated_by"
    ];

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';

}
