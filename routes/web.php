<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\patientController;
use App\Http\Controllers\user\profileController;
use App\Http\Controllers\DrugImportController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\MedicationPlanController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\DrugInteractionController;
use App\Http\Controllers\MedicationSafetyController;
use App\Http\Controllers\SymptomCheckerController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('patient' , [patientController::class , 'index'])->name('test');
Route::get('/', [DrugInteractionController::class, 'index']);
Route::post('/check', [DrugInteractionController::class, 'check'])->name('check-interaction');
Route::middleware(['auth'])->group(function () {
    Route::get('/medication-checker', [MedicationSafetyController::class, 'index']);
    Route::post('/medication-checker', [MedicationSafetyController::class, 'check']);
});
// Route::get('user/profile' , [App\Http\Controllers\user\profileController::class, 'index'])->name('user.profile')->middleware('auth');


// middleware w prefix 3bara 3an keys
Route::group(['middleware' => ['auth' , 'profile']  , 'prefix' => 'profile'] , function(){

    //profile controller
    Route::get('/' , [ProfileController::class , 'index'])->name('profile');
    Route::put('/' , [ProfileController::class , 'update'])->name('profile.update');
    Route::get('/show', [ProfileController::class, 'show'])->name('profile.show');
});




Route::get('/import-drugs', [DrugImportController::class, 'showImportForm']);
Route::post('/import-drugs', [DrugImportController::class, 'import']);




Route::view('/chatbot', 'chatbot');
Route::post('/chatbot', [ChatbotController::class, 'respond']);


Route::middleware(['auth'])->group(function () {
    Route::get('/medication-plan', [MedicationPlanController::class, 'index'])->name('medication-plan.index');
    Route::post('/medication-plan', [MedicationPlanController::class, 'store'])->name('medication-plan.store');
});


Route::get('send-mail' , [EmailController::class ,'sendWelcomeEmail']);




Route::get('/symptom-checker', [SymptomCheckerController::class, 'showForm']);
Route::post('/predict-disease', [SymptomCheckerController::class, 'predict'])->name('predict.disease');
