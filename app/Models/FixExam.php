<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class FixExam extends Model
{
    protected $table = "fix_exam";

    protected $fillable = [
        "sub_id",
        "g_id",
        "chap_id",
        "cate_id",
        "fe_price",
        "created_date",
        "created_by",
        "updated_date",
        "updated_by"
    ];

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            $model->created_by = session("user")->account_id;
            $model->updated_by = session("user")->account_id;
        });

        static::updating(function($model)
        {
            $model->updated_by = session("user")->account_id;
        });
    }
}
