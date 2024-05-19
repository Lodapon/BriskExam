<?php

namespace App\Http\Controllers;

use App\Http\Utils\CalculateUtil;
use App\Models\BookShop;
use App\Models\BookShopCart;
use App\Models\BookShopCartDelivery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookshopController extends Controller
{
    //--------------- BOOKSHOP PAGE ------------------------

    function initialBookshop() {
        DB::enableQueryLog();
        $books = BookShop::query()
            ->where("book_available", "=", true)
            ->paginate(6, ["book_id","book_name","book_detail", "book_price", "book_img"]);

        Log::debug(DB::getQueryLog());

        return view("std.bookshop.bookshop")->with([
            "books" => $books,
            "countItemsInCart" => self::countItemsInCart()
        ]);
    }

    function addBookToCart($bookId): JsonResponse {
        DB::beginTransaction();
        BookShopCart::query()->create([
            "book_id" => $bookId,
        ]);
        DB::commit();

        return response()->json([
            "countItemsInCart"  => self::countItemsInCart()
        ]);
    }

    function searchBook(Request $request) {
        $filter = $request["filter"];
        $books = BookShop::query()
            ->where("book_name", "like", "%" . $filter . "%")
            ->orWhere("book_detail", "like", "%" . $filter . "%")
            ->paginate(6, ["book_id","book_name","book_detail", "book_price", "book_img"]);

        return view("std.bookshop.bookshop-item")->with([
            "books" => $books
        ]);
    }

    private function countItemsInCart(): int {
        return BookShopCart::query()
            ->where("created_by", "=", session("user")->account_id)
            ->count();
    }

    //--------------- CHECKOUT PAGE ------------------------

    function initialCheckout() {
        DB::enableQueryLog();
        $books = $this->getItemsDetailInCart();
        Log::info(DB::getQueryLog());

        return view("std.bookshop.checkout")->with([
            "books" => $books,
            "summary" => $this->countAndSumBooksInCart()
        ]);
    }

    function removeBookFromCart($bookId) {
        DB::beginTransaction();
        BookShopCart::query()
            ->where("book_id", "=", $bookId)
            ->where("created_by", "=", session("user")->account_id)
            ->delete();
        DB::commit();

        $books = $this->getItemsDetailInCart();

        return view("std.bookshop.checkout-item")->with([
            "books" => $books,
            "summary" => $this->countAndSumBooksInCart()
        ]);
    }

    private function getItemsDetailInCart() {
        $books = BookShopCart::query()
            ->leftJoin("book_shop", "book_shop_cart.book_id", "=", "book_shop.book_id")
            ->groupBy("book_id")
            ->where("book_shop_cart.created_by", "=", session("user")->account_id)
            ->get([
                "book_shop_cart.book_id",
                "book_name",
                "book_price",
                "book_available",
                "book_img",
                DB::raw("count(book_shop_cart.book_id) as countEachBook"),
                DB::raw("count(book_shop_cart.book_id)*book_price as sumBookPrice")
            ]);
        return $books;
    }

    private function countAndSumBooksInCart(): array {
        $summaryCart = BookShopCart::query()->join("book_shop as bs", "book_shop_cart.book_id", "=", "bs.book_id")
            ->where("book_shop_cart.created_by", "=", session("user")->account_id)
            ->first([DB::raw("count(*) as booksCount"), DB::raw("sum(book_price) as booksPrice")]);

        return [
            "booksCount" => $summaryCart->booksCount,
            "booksPrice" => $summaryCart->booksPrice,
            "shippingPrice" => CalculateUtil::shippingPrice($summaryCart->booksCount)
        ];
    }


    function updateBookAmount(Request $request) {
        $bookId = $request["bookId"];
        $bookAmount = $request["amount"];

        DB::beginTransaction();
        $countByBook = BookShopCart::query()
            ->where("book_id", "=", $bookId)
            ->where("created_by", "=", session("user")->account_id)
            ->count();

        if ($bookAmount > $countByBook) {
            //insert
            for ($i=0; $i<$bookAmount-$countByBook; ++$i) {
                BookShopCart::query()->create([
                    "book_id" => $bookId
                ]);
            }
        } else if ($countByBook > $bookAmount) {
            //delete
            BookShopCart::query()
                ->where("book_id" , "=", $bookId)
                ->where("created_by", "=", session("user")->account_id)
                ->limit($countByBook-$bookAmount)
                ->delete();
        } else {
            // it's equals, do nothing
        }

        $books = $this->getItemsDetailInCart();
        DB::commit();

        return view("std.bookshop.checkout-item")->with([
            "books" => $books,
            "summary" => $this->countAndSumBooksInCart()
        ]);
    }

    //--------------- DELIVERY PAGE ------------------------

    function initialDelivery() {
        $recentDelivery = $this->getDeliveryAddress();

        return view("std.bookshop.delivery")->with([
            "recentDelivery" => $recentDelivery
        ]);
    }

    function updateAddress(Request $request): JsonResponse {
        $name = $request["name"];
        $phone = $request["phone"];
        $addr = $request["addr"];

        DB::beginTransaction();
        DB::enableQueryLog();

        $existingDelivery = BookShopCartDelivery::query()
            ->where("created_by", "=", session("user")->account_id)
            ->exists();

        if ($existingDelivery) {
            BookShopCartDelivery::query()
                ->where("created_by", "=", session("user")->account_id)
                ->update([
                    "delivery_recipient_fullname" => $name,
                    "delivery_recipient_phone" => $phone,
                    "delivery_send_addr" => $addr
                ]);
        } else {
            BookShopCartDelivery::query()
                ->create([
                    "delivery_recipient_fullname" => $name,
                    "delivery_recipient_phone" => $phone,
                    "delivery_send_addr" => $addr
                ]);
        }

        Log::debug(DB::getQueryLog());
        DB::commit();


        return response()->json(true);
    }

    private function getDeliveryAddress() {
        return BookShopCartDelivery::query()
            ->where("created_by", "=", session("user")->account_id)
            ->orderBy("created_by", "desc")
            ->first(["delivery_recipient_fullname", "delivery_recipient_phone", "delivery_send_addr"]);
    }

    //--------------- SUMMARY PAGE ------------------------

    function initialSummary() {
        $recentDelivery = $this->getDeliveryAddress();
        return view("std.bookshop.payment")->with([
            "recentDelivery" => $this->getDeliveryAddress(),
            "summary" => $this->countAndSumBooksInCart()
        ]);
    }

    function walletPayment(Request $request) {
        $price = $request["price"];
        $userCredit = DB::table('v_user_credit')
            ->where('account_id', '=', session("user")->account_id)
            ->first();

        $balance = $userCredit->balance_amt;
//        Log::info("Balance : ".$balance);

        if ($price > $balance) {
            Log::warning("not enough credit");
            return response()->json(false);
        } else {
            DB::table('user_credit_trans')
                ->insert([
                    "tran_amt" => $price,
                    "balance_amt" => $balance - $price,
                    "balance_amt_bf" => $balance,
                    "tran_type" => 'B',
                    "created_date" => date('Y-m-d H:i:s'),
                    "created_by" => session("user")->account_id,
                    "account_id" => session("user")->account_id,
                ]);
        }

        return response()->json(true);
    }

}
