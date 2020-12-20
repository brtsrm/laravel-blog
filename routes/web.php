<?php

use App\Http\Controllers\Back\ArticleController;
use App\Http\Controllers\Back\Auth;
use App\Http\Controllers\Back\CategroyController;
use App\Http\Controllers\back\ConfigController;
use App\Http\Controllers\Back\Dashboard;
use App\Http\Controllers\Back\PageController;
use App\Http\Controllers\Front\HomePage;
use Illuminate\Support\Facades\Route;

/*
Back End Kısmı
 */

Route::get('site-bakimda',function(){
    return view('fronts.offline');
});

Route::prefix('admin')->name('admin.')->middleware("isLogin")->group(function () {
    Route::get('giris', [Auth::class, "login"])->name("auth");
    Route::post('giris', [Auth::class, "loginPost"])->name('auth.post');
});

Route::prefix('admin')->name('admin.')->middleware("isAdmin")->group(function () {
    // Makaleler
    Route::get('/makaleler/silinenler', [ArticleController::class, "trashed"])->name('trashed.article');
    Route::resource('makaleler', ArticleController::class);
    Route::get('switch', [ArticleController::class, "switch"])->name('switch');
    Route::get('/deletearticle/{id}', [ArticleController::class, "delete"])->name('delete.article');
    Route::get('/recoverarticle/{id}', [ArticleController::class, "recover"])->name('recover.article');
    Route::get('/harddelete/{id}', [ArticleController::class, "harddelete"])->name('hard.delete.article');
    Route::get('panel', [Dashboard::class, "index"])->name("dashboard");
    // Kategoriler
    Route::get('/category', [CategroyController::class, "index"])->name('category.index');
    Route::get('/category/switch', [CategroyController::class, "switch"])->name('category.switch');
    Route::post('/category/create', [CategroyController::class, "create"])->name('category.create');
    Route::get('/category/getData', [CategroyController::class, "getData"])->name('category.getData');
    Route::post('/category/update', [CategroyController::class, "update"])->name('category.update');
    Route::post('/category/delete', [CategroyController::class, "delete"])->name('category.delete');
    // Sayfalar
    Route::get('/sayfalar', [PageController::class, "index"])->name('page.index');
    Route::get('/sayfalar/edit/{id}', [PageController::class, "edit"])->name('page.edit');
    Route::get('/sayfalar/delete/{id}', [PageController::class, "delete"])->name('page.delete');
    Route::get('/sayfalar/switch', [PageController::class, "switch"])->name('page.switch');
    Route::get('/sayfalar/create', [PageController::class, "create"])->name('page.create');
    Route::post('/sayfalar/createPage', [PageController::class, "createPage"])->name('page.createPage');
    Route::post('/sayfalar/editPage/{id}', [PageController::class, 'editPage'])->name('page.editPage');
    Route::get('/sayfalar/pageOrder', [PageController::class, 'pageOrder'])->name('page.orders');
    Route::get('/ayarlar',[ConfigController::class,'index'])->name('config.setting');
    Route::post('/ayarlar/create',[ConfigController::class,'updateSetting'])->name('config.setting.post');
    Route::get('cikis', [Auth::class, "logout"])->name("logout");
});

/*

Fron End Kısmı

 */

Route::get('/', [HomePage::class, "index"])->name("homepage");
Route::get('/iletisim', [HomePage::class, "contact"])->name("contact");
Route::post('/iletisim', [HomePage::class, "contactPost"])->name("contact.post");
Route::get('/sayfa', [HomePage::class, "index"]);
Route::get('/kategori/{category}', [HomePage::class, "category"])->name("category");
Route::get('/{category}/{slug}', [HomePage::class, "single"])->name("single");
Route::get('/{sayfa}', [HomePage::class, "page"])->name("page");
