<?php

namespace App\Http\Controllers;

use App\Models\BookShop;

class LandingController
{
    function initialBookshop() {
        $books = BookShop::query()
            ->limit(10)
            ->get(["book_id","book_name","book_detail", "book_price", "book_img"]);

        return view("landing")->with([
            "books" => $books
        ]);
    }
}
