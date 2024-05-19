<?php

use App\Http\Controllers\BookshelfController;
use App\Http\Controllers\BookshopController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PostBackController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\TestFixController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TestMockController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Groups of routes that needs authentication to access.
 */
Route::group(['middleware' => ['auth']], function () {

    Route::get('/logout', function() {
        session()->flush();
        return redirect("/");
    });

    // Routes for Test-fix
    Route::prefix("testfix")->group(function() {

        Route::get('/', function () {return view('test-fix.index');});
        Route::get("/ckdemo", function() {return view("test-fix.ckdemo");});

        Route::post('/search', [TestFixController::class,'getTemplate'])
            ->name('fix.search');

        Route::get('/chap/', [TestFixController::class, "initNewChapterPage"])
            ->name('fix.add');
        Route::get('/chap/{chapId}', [TestFixController::class, "initEditChapterPage"])
            ->where('chapId', '\d+');
        Route::get('/chap/questionListYajra/{chapId}', [TestFixController::class, 'getQuestionListYajra'])
            ->where('chapId', '\d+');

        Route::post('/chap/save', [TestFixController::class, 'createChapter']);
        Route::post('/chap/{chapId}/save', [TestFixController::class, 'updateChapter'])
            ->where('chapId', '\d+');;

        Route::get('/chap/{chapId}/question/', [TestFixController::class, "initEmptyQuestionPage"])
            ->where('chapId', '\d+');
        Route::get('/chap/{chapId}/question/{questionId}', [TestFixController::class, "initQuestionPage"])
            ->where('chapId', '\d+')
            ->where('questionId', '\d+');
        Route::post('/chap/{chapId}/question/save', [TestFixController::class, "insertNewQuestion"])
            ->where('chapId', '\d+');
        Route::post('/chap/{chapId}/question/{questionId}/save', [TestFixController::class, 'updateExistQuestion'])
            ->where('chapId', '\d+')
            ->where('questionId', '\d+');
        Route::post('/sendAppr', [TestFixController::class, 'sendAppr']);
        Route::delete('/delfix',[TestFixController::class,'delFixDetail']);
    });

    Route::get('/testfix-filter', function () {
        return view('testfixFilter');
    });

    Route::get('api/subject',[MasterDataController::class,'subjects'])->name('list.subject');
    Route::get('api/grade',[MasterDataController::class,'grades'])->name('list.grade');
    Route::get('api/chapter',[MasterDataController::class,'chapters'])->name('list.chapter');
    Route::get('api/category/{sub_id}',[MasterDataController::class,'categories'])->name('list.categorie');
    Route::get('api/level',[MasterDataController::class,'levels'])->name('list.level');
    Route::get('api/mockname',[MasterDataController::class,'mockNames'])->name('list.mockname');
    Route::post('api/subject',[MasterDataController::class,'addSubject'])->name('add.subject');
    Route::post('api/mockname',[MasterDataController::class,'addMockName'])->name('add.mockname');
    Route::post('api/grade',[MasterDataController::class,'addGrades'])->name('add.grade');
    Route::post('api/cate',[MasterDataController::class,'addCategories'])->name('add.categorie');
    Route::get('api/tags',[MasterDataController::class,'tags'])->name('list.tags');
    Route::post('api/addCredit',[UserController::class,'addCredit']);
    Route::delete('api/subject',[MasterDataController::class,'delSubject'])->name('del.subject');
    Route::delete('api/grade',[MasterDataController::class,'delGrades'])->name('del.grade');
    Route::delete('api/cate',[MasterDataController::class,'delCategories'])->name('del.categorie');
    Route::delete('api/mockname',[MasterDataController::class,'delMockName'])->name('del.mockname');
    Route::get('/templatemockup', function () {
        return view('templatemockup');
    });
    Route::get('/inputmockup', function () {
        return view('inputmockup');
    });

    // Routes for Admin
    Route::group(['prefix' => 'admin'], function()
    {
        Route::get('/ausers', [AdminController::class,'listUser']);
        Route::get('/dashboard',[AdminController::class,'dashboard']);
        // function(){return view('admin/dashboard');});
        Route::get('/addcredit',function(){return view('admin/addcredit');});

        Route::get('/print', function(){
            return view('admin/print');
        });
        Route::post('/templatebook',[BookshelfController::class, "createtemplate"])->name('admin.addtemplate');
        Route::get('/booktmplist',[BookshelfController::class, "bookTmpYarjaList"])->name('admin.tmplist');
        Route::get('/edittmp/{beId}', [BookshelfController::class, "initTmpEditPage"])
        ->where('beId', '\d+');
        Route::delete('/deltmp',[BookshelfController::class,'delTmp']);
        Route::post('/updtmp',[BookshelfController::class,'updtemplate'])->name('admin.updatetemplate');
        Route::get('/printtmp/{beId}', [BookshelfController::class, "initTmpViewPage"])
        ->where('beId', '\d+');
        Route::get('/bookshelf', function(){
            return view('admin/bookshelf');
        });
        Route::get('/bookshelf/books', [BookshelfController::class,'getBookList']);
        Route::post('/bookshelf/book/save', [BookshelfController::class,'save']);
        Route::delete('/bookshelf/book/{bookId}', [BookshelfController::class,'delete'])
            ->where('bookId', '\d+');
        Route::get('/bookshelf/book/{bookId}', [BookshelfController::class,'getBookDetail'])
            ->where('bookId', '\d+');

        Route::get('/users', [UserController::class,'index'])->name('users.index');
        Route::get('/userslist', [UserController::class,'getUser'])->name('users.list');
        Route::get('/users/view/{id}', [UserController::class,'show'])->name('users.view');
        Route::get('/userscr', [UserController::class,'getUserCredit'])->name('usercr.list');

        Route::post('/viewFix',[AdminController::class,'viewFix'])->name('admin.vf');
        Route::post('/viewMock',[AdminController::class,'viewFix'])->name('admin.vm');
        Route::post('/appr',[AdminController::class,'approve'])->name('admin.appr');
        Route::post('/deliver',[AdminController::class,'deliver'])->name('admin.deliver');
    });
    Route::get('/viewprint', function(){
        return view('/admin/viewprint');
    });

    // Routes for Student
    Route::group(['prefix' => 'std'], function()
    {
        Route::group(['prefix' => 'fix'], function(){
            Route::get('/library', [StudentController::class,'fixlist'])->name('std.fixlist');
            Route::post('/library', [StudentController::class,'fixlist'])->name('std.fixlist');
            Route::post('/dotest', [StudentController::class,'dotest'])->name('std.test');
            Route::post('/finish', [StudentController::class,'finishTest'])->name('std.finish');
            Route::post('/pause', [StudentController::class,'pauseTest'])->name('std.pause');
        });
        Route::group(['prefix' => 'mock'], function(){
            Route::get('/index', [StudentController::class,'mocklist'])->name('std.mocklist');
            Route::post('/index', [StudentController::class,'mocklist'])->name('std.mocklist');
            Route::post('/dotest', [StudentController::class,'doMocktest'])->name('std.mtest');
            Route::post('/finish', [StudentController::class,'finishMockTest'])->name('std.mock.finish');
            Route::post('/pause', [StudentController::class,'pauseMockTest'])->name('std.mock.pause');
        });
        Route::post('/resume', [StudentController::class,'resumeTest'])->name('std.resume');
        // Route::get('/dashboard',function(){return view('std.dashboard');})->name('std.db');
        Route::post('/chk/purchase', [StudentController::class,'chkFixPurchase']);
        Route::get('/dashboard',[StudentController::class,'dashboard'])->name('std.db');
        Route::get('/edit', [StudentController::class,'edit'])->name('std.edit');

        Route::get('/bookshop', [BookshopController::class, 'initialBookshop']);
        Route::get('/bookshop/search', [BookshopController::class, 'searchBook']);
        Route::post('/bookshop/{bookId}', [BookshopController::class, 'addBookToCart'])
            ->where('bookId', '\d+');

        Route::get('/bookshop/checkout', [BookshopController::class, 'initialCheckout']);
        Route::delete('/bookshop/checkout/{bookId}', [BookshopController::class, 'removeBookFromCart'])
            ->where('bookId', '\d+');
        Route::put('/bookshop/checkout/update', [BookshopController::class, 'updateBookAmount']);

        Route::get('/bookshop/delivery',[BookshopController::class, 'initialDelivery']);
        Route::put('/bookshop/delivery/save',[BookshopController::class, 'updateAddress']);

        Route::get('/bookshop/payment', [BookshopController::class, "initialSummary"]);
        Route::post('/bookshop/payment/wallet', [BookshopController::class, "walletPayment"]);


        Route::get('/exlist', [StudentController::class,'getExamHist'])->name('std.exhist');
        Route::post('/update', [StudentController::class,'updateUser'])->name('std.update');

        Route::post('/viewFix',[StudentController::class,'viewFix'])->name('std.vf');
        Route::post('/viewMock',[StudentController::class,'viewMock'])->name('std.vm');

        Route::get('/addCredit', function () {
            return view("std.std-addcredit");
        });
    });

    // Routes for Test-mock
    Route::group(['prefix' => 'testmock'], function()
    {
        Route::get('/',[TestMockController::class, "initialPage"])->name('mock.add');
        Route::post('/save', [TestMockController::class, 'save']);
        Route::get('/templatemock',function(){return view('test-mock.test-mock-template');})->name('mock.template');
        Route::post('/templatemock',[TestMockController::class, "template"])->name('mock.addtemplate');
        Route::get('/edit',function(){return view('test-mock.edit');})->name('mock.edit');
        Route::post('/saveW', [TestMockController::class, 'saveW']);
        Route::get('/mocklist',[TestMockController::class, "mockYarjaList"])->name('mock.list');
        Route::get('/question/{questionId}', [TestMockController::class, "initQuestionPage"])
            ->where('questionId', '\d+');
        Route::post('/question/{questionId}/save', [TestMockController::class, 'updateExistQuestion'])
            ->where('questionId', '\d+');
        Route::post('/question/{questionId}/saveW', [TestMockController::class, 'updateExistQuestionW'])
            ->where('questionId', '\d+');
        Route::delete('/delmock',[TestMockController::class,'delMockDetail']);
        Route::get('/mocktmplist',[TestMockController::class, "mockTmpYarjaList"])->name('mock.tmplist');
        Route::post('/changeStatus', [TestMockController::class, 'changeStatus']);
        Route::get('/edittmp/{meId}', [TestMockController::class, "initTmpEditPage"])
        ->where('meId', '\d+');
        Route::delete('/delmockTmp',[TestMockController::class,'delMockTmp']);
        Route::post('/updtmpmock',[TestMockController::class,'updtemplate'])->name('mock.updatetemplate');
    });
    Route::get('/viewtemplate', function(){
        return view('/test-mock/test-mock-viewtemplate');
    });

});

// Route::get('/creator/dashboard',function() {
// 	return view('creator/dashboard');
// });
Route::get('creator/dashboard',[UserController::class,'dashboard'])->name('crt.db');
Route::get('/yarjaCrt', [UserController::class,'getLastTrans'])->name('crt.tran');
Route::get('/chk/dashboard', [UserController::class,'chkDashboard'])->name('chk.db');
Route::get('/', [LandingController::class, "initialBookshop"]);


Route::get('/home', function () {
    return view('home');
});

Route::get('/signup', function () {
    return view('signup');
});

Route::post('/signup', [SignUpController::class, 'signUp']);
// Route::get('/getProfileImg', [SignUpController::class,'showProfileImg']);
Route::post('/chk/mail', [SignUpController::class, 'chkMail']);
// Route::post('/chk/user', [SignUpController::class, 'chkUser']);

Route::post('/login', [LandingController::class, "initialBookshop"])->middleware('auth');

Route::get('/login', [SignUpController::class, 'signUpErr']);
// Route::get('/logout', function() {
//     session()->flush();
//     return redirect("/");
// });

Route::prefix("reset")->group(function() {
    Route::get("/", [ResetPasswordController::class, 'initialResetForm']);
    Route::post("/request", [ResetPasswordController::class, 'requestReset']);

    Route::get("/confirm/{oldPassHash}", [ResetPasswordController::class, 'initialConfirmForm']);
    Route::post("/confirm", [ResetPasswordController::class, 'updateNewPassword']);
});

Route::post("/postback", [PostBackController::class, 'recordPaymentTransaction']);

