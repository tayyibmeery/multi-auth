<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BillOfMaterialController;
use App\Http\Controllers\ProductionRunController;
use App\Http\Controllers\StockLedgerController;
use App\Http\Controllers\ReportController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalePaymentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SalaryPaymentController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\WebsiteSettingsController;
use App\Http\Controllers\ServiceProductController;
use App\Http\Controllers\ContactMessageController;

// ========== WEBSITE ROUTES (Public) ==========
Route::get('/', [WebsiteController::class, 'home'])->name('website.home');
Route::get('/about', [WebsiteController::class, 'about'])->name('website.about');
Route::get('/serproducts', [WebsiteController::class, 'products'])->name('website.serproducts');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('website.contact');
Route::post('/contact', [WebsiteController::class, 'submitContact'])->name('website.contact.submit');

// ========== AUTHENTICATION ROUTES ==========
Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [UserAuthController::class, 'login']);
Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

// ========== PROTECTED ROUTES (Both Admin and User) ==========
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Items - CRUD
    Route::get('/items/out-of-stock', [ItemController::class, 'outOfStock'])->name('items.out-of-stock');
    Route::get('/items/low-stock', [ItemController::class, 'lowStock'])->name('items.low-stock');
    Route::get('/items/search', [ItemController::class, 'search'])->name('items.search');
    Route::resource('items', ItemController::class);

    // Purchases - CRUD
    Route::resource('purchases', PurchaseController::class);

    // Products - CRUD
    Route::get('/products/low-stock', [ProductController::class, 'lowStock'])->name('products.low-stock');
Route::get('/products/out-of-stock', [ProductController::class, 'outOfStock'])->name('products.out-of-stock');
    Route::resource('products', ProductController::class);

    // Bill of Materials - CRUD
    Route::resource('boms', BillOfMaterialController::class);

    // Production Runs - CRUD
    Route::resource('production-runs', ProductionRunController::class);

    // Stock Ledger - Read only
    Route::get('/stock-ledgers', [StockLedgerController::class, 'index'])->name('stock-ledgers.index');
    Route::get('/stock-ledgers/item/{itemId}', [StockLedgerController::class, 'itemLedger'])->name('stock-ledgers.item');
    Route::get('/stock-ledgers/product/{productId}', [StockLedgerController::class, 'productLedger'])->name('stock-ledgers.product');

    // Sales Routes
    Route::resource('sales', SaleController::class);
    Route::get('sales/{sale}/print', [SaleController::class, 'printInvoice'])->name('sales.print');
    Route::get('sales/{sale}/payments/create', [SalePaymentController::class, 'create'])->name('sales.payments.create');
    Route::post('sales/{sale}/payments', [SalePaymentController::class, 'store'])->name('sales.payments.store');

    // Customer Routes
    Route::resource('customers', CustomerController::class);

    // Accounting Routes
    Route::prefix('accounting')->name('accounting.')->group(function () {
        Route::get('dashboard', [AccountingController::class, 'dashboard'])->name('dashboard');
        Route::get('trial-balance', [AccountingController::class, 'trialBalance'])->name('trial-balance');
        Route::get('income-statement', [AccountingController::class, 'incomeStatement'])->name('income-statement');
        Route::get('balance-sheet', [AccountingController::class, 'balanceSheet'])->name('balance-sheet');
        Route::get('vouchers', [AccountingController::class, 'vouchers'])->name('vouchers');
         Route::get('vouchers/create', [AccountingController::class, 'createVoucher'])->name('vouchers.create');
    Route::post('vouchers', [AccountingController::class, 'storeVoucher'])->name('vouchers.store');
    });

    // Expense Routes
    Route::resource('expenses', ExpenseController::class);

    // Employee Routes
    Route::resource('employees', EmployeeController::class);

    // Salary Routes
    Route::get('employees/{employee}/salaries/create', [SalaryPaymentController::class, 'create'])->name('salaries.create');
    Route::post('salaries', [SalaryPaymentController::class, 'store'])->name('salaries.store');

    // Reports Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('sales', [ReportController::class, 'salesReport'])->name('sales');
        Route::get('stock', [ReportController::class, 'stockReport'])->name('stock');
        Route::get('purchases', [ReportController::class, 'purchaseReport'])->name('purchases');
        Route::get('production', [ReportController::class, 'productionReport'])->name('production');
        Route::get('low-stock', [ReportController::class, 'lowStockReport'])->name('low-stock');
        Route::get('stock-valuation', [ReportController::class, 'stockValuation'])->name('stock-valuation');
    });

    // ========== ADMIN ONLY ROUTES ==========
    Route::middleware(['admin'])->group(function () {
        // Admin Dashboard
        Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

        // Vendors - CRUD (Admin only)
        Route::resource('vendors', VendorController::class);

        // Categories - CRUD (Admin only)
        Route::resource('categories', CategoryController::class);

        // Website Management Routes
        Route::prefix('admin')->name('admin.')->group(function () {
            // Dashboard
            Route::get('/website', [WebsiteSettingsController::class, 'dashboard'])->name('website.dashboard');

            // Company Information
            Route::get('/company', [WebsiteSettingsController::class, 'company'])->name('company.index');
            Route::post('/company', [WebsiteSettingsController::class, 'updateCompany'])->name('company.update');

            // Service Products Management (Frontend Website Products)
            Route::get('/service-products', [ServiceProductController::class, 'index'])->name('service-products.index');
            Route::get('/service-products/create', [ServiceProductController::class, 'create'])->name('service-products.create');
            Route::post('/service-products', [ServiceProductController::class, 'store'])->name('service-products.store');
            Route::get('/service-products/{serviceProduct}/edit', [ServiceProductController::class, 'edit'])->name('service-products.edit');
            Route::put('/service-products/{serviceProduct}', [ServiceProductController::class, 'update'])->name('service-products.update');
            Route::delete('/service-products/{serviceProduct}', [ServiceProductController::class, 'destroy'])->name('service-products.destroy');

            // Contact Messages
            Route::get('/messages', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
    Route::put('/messages/{message}', [ContactMessageController::class, 'update'])->name('messages.update');
    Route::delete('/messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
        });
    });
});

// ========== API ROUTES ==========
// Bill of Materials Items API for production
Route::get('/boms/{bom}/items', function ($bom) {
    $bom = \App\Models\BillOfMaterial::with('bomItems.item')->findOrFail($bom);
    return response()->json([
        'items' => $bom->bomItems->map(function ($bomItem) {
            return [
                'id' => $bomItem->id,
                'quantity' => $bomItem->quantity,
                'item' => [
                    'id' => $bomItem->item->id,
                    'name' => $bomItem->item->name,
                    'code' => $bomItem->item->code,
                    'current_stock' => $bomItem->item->current_stock,
                    'current_price' => $bomItem->item->current_price,
                    'unit' => $bomItem->item->unit,
                ]
            ];
        })
    ]);
})->name('boms.items');

// ========== FALLBACK ROUTE ==========
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});