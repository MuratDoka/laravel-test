<?php

use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

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

// Redirect root to the login page
Route::get('/', function () {
    return redirect()->route('login');
});

// All of these routes require authentication
Route::middleware(['auth','verified'])->group(function () {
    // Keep the old dashboard shortcut, but point it at /sales
    Route::redirect('/dashboard', '/sales')->name('coffee.sales');

    Route::resource('sales', SaleController::class)
         ->only(['index', 'store'])
         ->names([
             'index' => 'sales.index',
             'store' => 'sales.store',
         ]);

    // Your existing shipping partners page
    Route::get('/shipping-partners', function () {
        return view('shipping_partners');
    })->name('shipping.partners');

});


require __DIR__.'/auth.php';
