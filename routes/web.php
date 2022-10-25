<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SessionController;
use App\Models\Person;
use App\Models\Product;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\TestController;

Route::get('/home', [AuthorController::class, 'index']);
Route::get('/add', [AuthorController::class, 'add']);
Route::post('/add', [AuthorController::class, 'create']);
Route::get('/edit', [AuthorController::class, 'edit']);
Route::post('/edit', [AuthorController::class, 'update']);
Route::get('/delete', [AuthorController::class, 'delete']);
Route::post('/delete', [AuthorController::class, 'remove']);
Route::get('/find', [AuthorController::class, 'find']);
Route::post('/find', [AuthorController::class, 'search']);
Route::get('/author/{author}',[AuthorController::class, 'bind']);
Route::prefix('book')->group(function () {
  Route::get('/', [BookController::class, 'index']);
  Route::get('/add', [BookController::class, 'add']);
  Route::post('/add', [BookController::class, 'create']);
});
Route::get('/relation', [AuthorController::class, 'relate']);

Route::get('/session', [SessionController::class, 'getSes']);
Route::post('/session', [SessionController::class, 'postSes']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/home', [AuthorController::class, 'index'])->middleware('auth');

Route::get('/auth', [AuthorController::class,'check']);
Route::post('/auth', [AuthorController::class,'checkUser']);

Route::get('/softdelete', function () {
    $result = Person::find(1)->delete();
    if($result){
        return "論理削除されました";
    }
});

Route::get('softdelete/get', function () {
    $person = Person::onlyTrashed()->get();
    return $person;
});

Route::get('softdelete/store', function() {
    $result = Person::onlyTrashed()->restore();
    return $result;
});

Route::get('softdelete/absolute', function() {
    $result = Person::onlyTrashed()->forceDelete();
    return $result;
});

Route::get('uuid',function() {
    $products = Product::all();
    foreach($products as $product){
        echo $product.'<br>';
    }
});

Route::get('fill', [SchoolController::class,'fillSchool']);
Route::get('create', [SchoolController::class,'createSchool']);

Route::get('/building', [TestController::class, 'index']);

Route::get('/building/{room}', function ($room) {
    return "部屋番号は" . $room . "です";
});