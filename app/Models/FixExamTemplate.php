<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixExamTemplate extends Model
{
    use HasFactory;

    protected $table = "fix_exam";

    protected $primaryKey = 'fe_id';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
    protected $fillable = [
        'fe_id',
        'sub_id',
        'g_id',
        'cate_id',
        'chap_id',
        'created_date',
    ];

    public function subject()
    {
        return $this->hasOne(Subject::class, 'sub_id');
    }

    public function grade()
    {
        return $this->hasOne(Grade::class, 'g_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'cate_id');
    }

    public function chapter()
    {
        return $this->hasOne(Chapter::class, 'chap_id');
    }
}
