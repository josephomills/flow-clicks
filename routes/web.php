<?php

// Admin Management controllers
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ClicksController;
use App\Http\Controllers\Admin\DenominationMgntController;
use App\Http\Controllers\Admin\InviteController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\ZoneController;

// General Controllers
use App\Http\Controllers\LinkGroupController;
use App\Http\Controllers\LinkTypeController;
use App\Http\Controllers\UrlRedirectController;

// Denomination User Specific Controllers
use App\Http\Controllers\User\DenominationController;
use App\Http\Controllers\UserLinkController;

use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect('login');
});

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard - Role-based redirection
    Route::get('dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return view('admin.dashboard');
        }
        return view('user.dashboard');
    })->name('dashboard');

    // Profile (accessible to all authenticated users)
    Route::view('profile', 'user.profile')->name('profile');

    // User Routes Group
    Route::middleware(['role:user'])->group(function () {

        // Link Management
        Route::resource('links', UserLinkController::class)->names('user.links');

        // Denominations
        Route::get('denominations', [DenominationController::class, 'index'])
            ->name('denominations.index');
    });

    Route::get('group/{linkGroup}', [LinkGroupController::class, 'show'])->name('link-group.show');
    Route::get('group/{linkGroup}/edit', [LinkGroupController::class, 'edit'])->name('link-group.edit');
    Route::put('group/{linkGroup}', [LinkGroupController::class, 'update'])->name('link-group.update');



    // ======================================================================================


    // Admin Routes Group
    Route::prefix('admin')->name('admin.')->middleware(['role:admin', 'auth'])->group(function () {

        // Settings
        Route::get('settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('settings', [SettingsController::class, 'store'])->name('settings.store');

        // Denominations Management
        Route::resource('denominations', DenominationMgntController::class);

        // Zones Management
        Route::resource('zones', ZoneController::class);

        // Link Types Management
        Route::resource('linktypes', LinkTypeController::class);

        // Links Management
        Route::resource('links', LinkController::class);

        // Clicks Management
        Route::resource('clicks', ClicksController::class);

        // User Management
        Route::resource('users', UserManagementController::class);

        // Analytics Management
        Route::resource('analytics', AnalyticsController::class);
    });
});

// ======================================================================================


// Invitation Routes (Public/Semi-public)
Route::group(['prefix' => 'invite'], function () {
    Route::get('/', [InviteController::class, 'invite'])->name('invite');
    Route::post('/', [InviteController::class, 'process'])->name('process');
    Route::get('accept/{token}', [InviteController::class, 'accept'])->name('invite.accept');
    Route::post('complete/{token}', [InviteController::class, 'completeRegistration'])->name('invite.complete');
});

// ======================================================================================

// Click Tracking Routes (Public)
Route::prefix('click')->group(function () {
    // Route with denomination
    Route::get('/{short_url}/{denomination}', [UrlRedirectController::class, 'index'])
        ->name('links.analytics.with_denomination');

    // Route without denomination
    Route::get('/{short_url}', [UrlRedirectController::class, 'index'])
        ->name('links.analytics');
});

// Subdomain Click Tracking
Route::domain('click.localhost')->group(function () {
    Route::get('/{short_url}/{denomination}', [UrlRedirectController::class, 'index'])
        ->name('links.analytics.subdomain');
});


// ======================================================================================
// Development/Testing Routes
if (app()->environment(['local', 'testing'])) {
    Route::get('/test-email', function () {
        try {
            Mail::raw('This is a plain test email from Laravel.', function ($message) {
                $message->to('komla.wilson.the.ceo@gmail.com')
                    ->subject('Laravel Test Email');
            });

            return 'Test email sent successfully.';
        } catch (\Exception $e) {
            \Log::error('Test email failed', ['error' => $e->getMessage()]);
            return 'Failed to send test email: ' . $e->getMessage();
        }
    });
}

require __DIR__ . '/auth.php';