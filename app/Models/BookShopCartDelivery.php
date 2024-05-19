<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BookShopCartDelivery extends Model
{
    protected $table = "book_shop_cart_delivery";

    protected $fillable = [
        "delivery_recipient_fullname",
        "delivery_recipient_phone",
        "delivery_send_addr",
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
