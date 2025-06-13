<?php

use App\Http\Controllers\AdminLinkController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\DenominationController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\LinkTypeController;
use App\Http\Controllers\UrlRedirectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLinkController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\AdminSettingsController;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;


Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('home.index');
});

Route::get('dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return view('admin.dashboard');
    }
    return view('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::view('profile', 'user.profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('admin/settings', [AdminSettingsController::class, 'index'])
    ->middleware(['auth', 'role:admin', 'verified'])
    ->name('admin.settings');

Route::post('admin/settings', [AdminSettingsController::class, 'store'])
    ->middleware(['auth', 'role:admin', 'verified'])
    ->name('admin.settings.store');



Route::resource(
    '/links',
    UserLinkController::class,
    [
        'names' => [
            'index' => 'user.links',
            'create' => 'user.links.create',
            'store' => 'user.links.store',
            'show' => 'user.links.show',
            'edit' => 'user.links.edit',
            'update' => 'user.links.update',
            'destroy' => 'user.links.destroy',
        ],


    ]
)->middleware(['auth', 'verified', 'role:user']);
// Route::get('/links/{link}/analytics', [LinkController::class, 'analytics'])->name('links.analytics');


Route::resource(
    '/admin/denominations',
    DenominationController::class,
    [
        'names' => [
            'index' => 'admin.denominations',
            'create' => 'admin.denominations.create',
            'store' => 'admin.denominations.store',
            'show' => 'admin.denominations.show',
            'edit' => 'admin.denominations.edit',
            'update' => 'admin.denominations.update',
            'destroy' => 'admin.denominations.destroy',
        ],


    ]
)->middleware(['auth', 'verified', 'role:admin']);
Route::resource(
    '/admin/zones',
    ZoneController::class,
    [
        'names' => [
            'index' => 'admin.zones',
            'create' => 'admin.zones.create',
            'store' => 'admin.zones.store',
            'show' => 'admin.zones.show',
            'edit' => 'admin.zones.edit',
            'update' => 'admin.zones.update',
            'destroy' => 'admin.zones.destroy',
        ],


    ]
);
Route::resource(
    '/admin/linktypes',
    LinkTypeController::class,
    [
        'names' => [
            'index' => 'admin.linktypes',
            'create' => 'admin.linktypes.create',
            'store' => 'admin.linktypes.store',
            'show' => 'admin.linktypes.show',
            'edit' => 'admin.linktypes.edit',
            'update' => 'admin.linktypes.update',
            'destroy' => 'admin.linktypes.destroy',
        ],


    ]
)->middleware(['auth', 'verified', 'role:admin']);

Route::resource(
    '/admin/links',
    AdminLinkController::class,
    [
        'names' => [
            'index' => 'admin.links',
            'create' => 'admin.links.create',
            'store' => 'admin.links.store',
            'show' => 'admin.links.show',
            'edit' => 'admin.links.edit',
            'update' => 'admin.links.update',
            'destroy' => 'admin.links.destroy',
        ],


    ]
)->middleware(['auth', 'verified', 'role:admin']);

Route::resource(
    '/admin/users',
    UserController::class,
    [
        'names' => [
            'index' => 'admin.users',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ],


    ]
)->middleware(['auth', 'verified', 'role:admin']);

Route::resource(
    '/admin/analytics',
    AnalyticsController::class,
    [
        'names' => [
            'index' => 'admin.analytics',
            'create' => 'admin.analytics.create',
            'store' => 'admin.analytics.store',
            'show' => 'admin.analytics.show',
            'edit' => 'admin.analytics.edit',
            'update' => 'admin.analytics.update',
            'destroy' => 'admin.analytics.destroy',
        ],


    ]
)->middleware(['auth', 'verified', 'role:admin']);

Route::prefix('click')->group(function () {
    Route::get('/{short_url}/{denomination}', [UrlRedirectController::class, 'index'])->name('links.analytics');
});

Route::domain('click.localhost')->group(function () {
    Route::get('/{short_url}/{denomination}', [UrlRedirectController::class, 'index'])->name('links.analytics');

});


// Route::view('/invite', 'admin.users.invite')->name('admin.invite');
Route::get('invite', [InviteController::class, 'invite'])->name('invite');
Route::post('invite', [InviteController::class, 'process'])->name('process');
// {token} is a required parameter that will be exposed to us in the controller method
Route::get('accept/{token}', [InviteController::class, 'accept'])->name('invite.accept');
Route::post('invite/complete/{token}', [InviteController::class, 'completeRegistration'])->name('invite.complete');


Route::get('/test-email', function () {
    Mail::raw('This is a test email from Laravel.', function ($message) {
        $message->to('komla.wilson.the.ceo@gmail.com')  // Change this to your email
                ->subject('Laravel Test Email');
    });

    return 'Test email sent!';
});
require __DIR__ . '/auth.php';
