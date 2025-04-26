<?php
use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialAuthController;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/upload-form', [MediaController::class, 'uploadForm']);
    Route::post('/upload-media', [MediaController::class, 'uploadMedia']);
    Route::get('/view-files', [MediaController::class, 'viewFiles']);
    Route::get('/play-media/{id}', [MediaController::class, 'playMedia']);
});

Auth::routes();

// Social Login Routes
Route::get('login/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('social.login');
Route::get('login/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('social.callback');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/health', function () {
    return response()->json(['status' => 'healthy']);
});
