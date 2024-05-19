<?php


namespace App\Http\Controllers;


use App\Http\Utils\CalculateUtil;
use App\Http\Utils\PaysolutionConstants;
use App\Models\BookShopCart;
use App\Models\BookShopCartDelivery;
use App\Models\BookShopCartHist;
use App\Models\BookShopCartHistDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostBackController
{
    public function recordPaymentTransaction(Request $request) {
        $accountIdCustomer = $request["refno"];
//        $systemOrderNo = $request["orderno"];
        $paid = $request["total"];
        $productDetail = $request["productdetail"];
//        $status = $request["status"];
//        $statusName = $request["statusname"];
//        $statusDetail = $request["statusdetail"];

//        refno=999999999998
//        &orderno=100334406
//        &total=1.0000
//        &status=CP
//        &statusname=COMPLETED
//        &statusdatail=Transaction has been Approved
//            &=

        switch ($productDetail) {
            case PaysolutionConstants::PRODUCT_DETAIL_BOOKSHOP:
                $this->addBookshopHistAndClearCart($accountIdCustomer, $paid);
                break;
            case PaysolutionConstants::PRODUCT_DETAIL_STD_ADD_CREDIT:
                $request["credit"] = $paid;
                $request["accId"] = $accountIdCustomer;

                $user_account = DB::selectOne('select distinct * from user_account where account_id = ?', [$accountIdCustomer]);
                $user_account->password = null;
                $user_account->salt = null;
                session()->put("user", $user_account);

                $user = new UserController();
                $user->addCredit($request);
                break;
            //todo additional PostBack cases here
            default:
                Log::info("postback without specific case.");
        }

    }

    /**
     * @param $accountIdCustomer
     * @param $paid
     */
    private function addBookshopHistAndClearCart($accountIdCustomer, $paid): void
    {
        $books = self::getItemsDetailInCart($accountIdCustomer);
        $totalPrice = 0;
        foreach ($books as $book) {
            $totalPrice += ($book->sumBookPrice * $book->countEachBook)
                + CalculateUtil::shippingPrice($book->countEachBook);
        }

        if ($totalPrice != $paid) {
            Log::warning("Expect $totalPrice baht, but got $paid baht.");
        }

        $delivery = BookShopCartDelivery::query()
            ->where("created_by", "=", $accountIdCustomer)
            ->first();

        DB::beginTransaction();
        $hist = BookShopCartHist::query()->create([
            "hist_paid" => $paid,
            "hist_sent_addr" => $delivery->delivery_recipient_fullname
                . ' ' . $delivery->delivery_recipient_phone
                . ' ' . $delivery->delivery_send_addr,
            "hist_delivery_status" => "W",
            "created_by" => $accountIdCustomer,
            "updated_by" => $accountIdCustomer
        ]);

        foreach ($books as $book) {
            BookShopCartHistDetail::query()->create([
                "hist_book_id" => $book->book_id,
                "hist_book_price_paid" => $book->sumBookPrice,
                "hist_book_amount" => $book->countEachBook,
                "hist_id" => $hist->id,
                "created_by" => $accountIdCustomer,
                "updated_by" => $accountIdCustomer
            ]);
        }

        BookShopCart::query()
            ->where("created_by", "=", $accountIdCustomer)
            ->delete();

        DB::commit();
    }


    private function getItemsDetailInCart($accountIdCustomer) {
        $books = BookShopCart::query()
            ->leftJoin("book_shop", "book_shop_cart.book_id", "=", "book_shop.book_id")
            ->groupBy("book_id")
            ->where("book_shop_cart.created_by", "=", $accountIdCustomer)
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

}
