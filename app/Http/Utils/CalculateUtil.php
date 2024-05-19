<?php
/**
 * Created by IntelliJ IDEA.
 * User: LordGift
 * Date: 20-Aug-21
 * Time: 9:30 PM
 */

namespace App\Http\Utils;

class CalculateUtil
{

    /**
     * shipping price is +50 baht per 2 item
     *
     * @param $amount int amount of item to ship
     * @return int shippingPrice
     */
    public static function shippingPrice(int $amount) : Int
    {
        return (intdiv($amount,2)+($amount%2)) * 50;
    }

}
