<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BookShop extends Model
{
    protected $table = "book_shop";

    protected $fillable = [
        "book_name",
        "book_detail",
        "book_year",
        "book_total",
        "book_price",
        "book_available",
        "book_img",
        "created_date",
        "created_by",
        "updated_date",
        "updated_by",
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
