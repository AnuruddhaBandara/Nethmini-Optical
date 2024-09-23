<?php

use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->name('auth.')->group(function () {
    Route::get('/', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
});
Route::middleware(['auth', 'verified', 'branch_filter'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::prefix('category')->controller(CategoryController::class)->name('category.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/destroy/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('item')->controller(ItemController::class)->name('item.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/destroy/{id}', 'destroy')->name('destroy');
        Route::get('/categories-by-branch/{branchId}', 'getCategoriesByBranch')->name('get-categories-by-branch');
    });

    Route::prefix('supplier')->controller(SupplierController::class)->name('supplier.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/destroy/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('customer')->controller(CustomerController::class)->name('customer.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/destroy/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('stock')->controller(StockController::class)->name('stock.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/destroy/{id}', 'destroy')->name('destroy');
        Route::get('/get-item/{id}', 'getItem')->name('get-item');
        Route::get('/get-subtotal/{id}', 'getSubTotal')->name('get-item');
        Route::post('/add-temp-stock', 'addTempStock')->name('add-temp-stock');
        Route::get('/delete-all-temp-stock', 'deleteTempStock')->name('delete-all-temp-stock');
        Route::get('/delete-item/{id}', 'deleteItem')->name('delete-item');
        Route::get('/get-stock/{branch_id}', 'getStock')->name('get-stock');
    });
    Route::prefix('order')->controller(OrderController::class)->name('order.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/destroy/{id}', 'destroy')->name('destroy');
        Route::post('/add-lens-fees', 'addLensFee')->name('add-lens-fees');
        Route::post('/add-temp-orders', 'addTempOrders')->name('add-temp-orders');
        Route::get('/get-order-details/{branch_id}', 'getOrderDetails')->name('get-order-details');
        Route::get('/view/{id}', 'view')->name('view');
        Route::get('delete-item/{id}/{type}', 'deleteItem')->name('delete-item');
        Route::get('delete-all-temp-order/{branch_id}', 'deleteTempOrder')->name('delete-all-temp-order');
        Route::post('update-remain-payment/{id}', 'addPaymentBalance')->name('add-payment-balance');
        Route::get('download-invoice/', 'downloadInvoice')->name('download-invoice');
        Route::get('check-stock-availability/{itemId}', 'checkStockAvailability')->name('check-stock');
    });

    Route::prefix('admin')->controller(AdminManagementController::class)->name('admin.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/destroy/{id}', 'destroy')->name('destroy');
    });
    Route::prefix('report')->controller(ReportController::class)->name('report.')->group(function () {
        Route::get('/sales', 'getAllSales')->name('sales');
        Route::get('/inventory', 'getInventoryReport')->name('inventory');
        Route::get('/stock-management', 'getStockManagementReport')->name('stock-management');
        Route::get('/profit-loss', 'profitLossReport')->name('profit-loss');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
