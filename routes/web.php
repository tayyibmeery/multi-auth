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

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// User Authentication Routes
Route::prefix('user')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('user.login');
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('user.register');
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');
});

// Protected Routes - Both Admin and User
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Items - CRUD (Admin: full access, User: read and create)
    Route::get('/items/low-stock', [ItemController::class, 'lowStock'])->name('items.low-stock');
    Route::get('/items/search', [ItemController::class, 'search'])->name('items.search');
    Route::resource('items', ItemController::class);

    // Purchases - CRUD (Both can access)
    Route::resource('purchases', PurchaseController::class);

    // Products - CRUD (Both can access)
    Route::resource('products', ProductController::class);

    //   Bill of Materials  - CRUD (Both can access)
    Route::resource('boms', BillOfMaterialController::class);

    // Production Runs - CRUD (Both can access)
    Route::resource('production-runs', ProductionRunController::class);

    // Stock Ledger - Read only (Both can access)
    Route::get('/stock-ledgers', [StockLedgerController::class, 'index'])->name('stock-ledgers.index');
    Route::get('/stock-ledgers/item/{itemId}', [StockLedgerController::class, 'itemLedger'])->name('stock-ledgers.item');
    Route::get('/stock-ledgers/product/{productId}', [StockLedgerController::class, 'productLedger'])->name('stock-ledgers.product');

    // Reports - Read only
    Route::prefix('reports')->group(function () {
        Route::get('/stock', [ReportController::class, 'stockReport'])->name('reports.stock');
        Route::get('/purchases', [ReportController::class, 'purchaseReport'])->name('reports.purchases');
        Route::get('/production', [ReportController::class, 'productionReport'])->name('reports.production');
        Route::get('/low-stock', [ReportController::class, 'lowStockReport'])->name('reports.low-stock');
        Route::get('/stock-valuation', [ReportController::class, 'stockValuation'])->name('reports.stock-valuation');
    });
});

// Admin Only Routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

    // Vendors - CRUD (Admin only)
    Route::resource('vendors', VendorController::class);

    // Categories - CRUD (Admin only)
    Route::resource('categories', CategoryController::class);
});


//  Bill of Materials Items API for production
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

// Reports
Route::prefix('reports')->group(function () {
    Route::get('/stock', [ReportController::class, 'stockReport'])->name('reports.stock');
    Route::get('/purchases', [ReportController::class, 'purchaseReport'])->name('reports.purchases');
    Route::get('/production', [ReportController::class, 'productionReport'])->name('reports.production');
    Route::get('/low-stock', [ReportController::class, 'lowStockReport'])->name('reports.low-stock');
    Route::get('/stock-valuation', [ReportController::class, 'stockValuation'])->name('reports.stock-valuation');
});