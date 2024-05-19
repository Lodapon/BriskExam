<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BookShopCartHistDetail extends Model
{
    protected $table = "book_shop_cart_hist_detail";

    protected $fillable = [
        "hist_book_id",
        "hist_id",
        "hist_book_price_paid",
        "hist_book_amount",
        "created_date",
        "created_by",
        "updated_date",
        "updated_by",
    ];

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
//
//    protected static function boot()
//    {
//        parent::boot();
//
//        static::creating(function($model)
//        {
//            $model->created_by = session("user")->account_id;
//            $model->updated_by = session("user")->account_id;
//        });
//
//        static::updating(function($model)
//        {
//            $model->updated_by = session("user")->account_id;
//        });
//    }
}
