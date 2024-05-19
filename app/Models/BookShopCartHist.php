<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BookShopCartHist extends Model
{
    protected $table = "book_shop_cart_hist";

    protected $fillable = [
        "hist_paid",
        "hist_sent_addr",
        "hist_payment_status",
        "hist_delivery_status",
        "hist_detail_id",
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
