<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FraudAnalysisController;


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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/fraud-analysis/{record}/view', [FraudAnalysisController::class, 'show'])->name('fraud-analysis.view');
Route::get('/fraud-analysis/{record}/print', [FraudAnalysisController::class, 'print'])->name('fraud-analysis.print');
// Route::get('/login', function () {
//     return redirect(route('filament.admin.auth.login'));
// })->name('login');
Route::get('/logout', function () {
    Auth::logout();
    return redirect(route('login'));
})->name('logout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
