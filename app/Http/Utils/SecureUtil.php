<?php
/**
 * Created by IntelliJ IDEA.
 * User: LordGift
 * Date: 10-Dec-18
 * Time: 5:53 PM
 */

namespace App\Http\Utils;

class SecureUtil
{

    /**
     * hashing SHA-1 algorithm (get 40 chars)
     *
     * @param $arg string hashing input string
     * @return string hash
     */
    public static function sha1($arg) {
        return hash("sha1", $arg);
    }

    /**
     * hashing SHA-256 algorithm (get 64 chars)
     *
     * @param $arg string hashing input string
     * @return string hash
     */
    public static function sha256($arg) {
        return hash("sha256", $arg);
    }

    /**
     * Recursive function for generated N-level hash seperated with ":"
     *
     * @param $args array of string
     * @return string hash in n-level
     */
    public static function hashing(array $args) {
        $count = count($args);
        if($count == 2) {
            return self::sha256("$args[0]:$args[1]");
        }
        if($count > 2) {
            $sliced = array_slice($args,0,$count-1);
            $hashLvN = self::sha256( self::hashing($sliced).":".$args[$count-1]);
            return $hashLvN;
        }
        return "";
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
