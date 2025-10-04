<?php

use App\Livewire\Bobina\BobinaIndex;
use App\Livewire\Cliente\ClienteIndex;
use App\Livewire\Pago\PagoIndex;
use App\Livewire\Producto\ProductoIndex;
use App\Livewire\Proveedor\ProveedorIndex;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\User\UserIndex;
use App\Livewire\UserInfo\UserInfoIndex;
use App\Models\Cliente;
use App\Livewire\Compra\CompraIndex;
use App\Livewire\Extracto\ExtractoDetalle;
use App\Livewire\Extracto\ExtractoIndex;
use App\Livewire\Venta\VentaIndex;
use App\Livewire\Dashboard\DashboardIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('dashboard', DashboardIndex::class)->name('dashboard');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('user', UserIndex::class)->name('user.index');
    Route::get('user/informacion/{id}', UserInfoIndex::class)->name('user.informacion');

    Route::get('producto', ProductoIndex::class)->name('producto.index');
    Route::get('cliente', ClienteIndex::class)->name('cliente.index');
    Route::get('proveedor', ProveedorIndex::class)->name('proveedor.index');
    Route::get('bobina', BobinaIndex::class)->name('bobina.index');
    Route::get('pago', PagoIndex::class)->name('pago.index');

    Route::get('compra', CompraIndex::class)->name('compra.index');
    Route::get('venta', VentaIndex::class)->name('venta.index');

    Route::get('extracto', ExtractoIndex::class)->name('extracto.index');
    Route::get('extracto/detalle/{id}', ExtractoDetalle::class)->name('extracto.detalle');
});

require __DIR__ . '/auth.php';
