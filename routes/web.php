<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleLoginController;
use App\Livewire\Survey\DimensionsList;
use App\Livewire\Survey\CreateSurvey;
use App\Livewire\Survey\DetailSurvey;
use App\Livewire\Survey\OverviewSurveyAdmin;
use App\Livewire\Survey\FillSurvey;
use App\Livewire\Survey\FillSurveyDetail;
use App\Livewire\Option\CreateAnswerOptionPage;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// GoogleLoginController redirect and callback urls
Route::get('/login/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/login/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);


Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('forms', 'forms')->name('forms');
    Route::view('cards', 'cards')->name('cards');
    Route::view('charts', 'charts')->name('charts');
    Route::view('buttons', 'buttons')->name('buttons');
    Route::view('modals', 'modals')->name('modals');
    Route::view('tables', 'tables')->name('tables');
    Route::view('calendar', 'calendar')->name('calendar');
    Route::get('/dimensi', DimensionsList::class)->name('dimensi');
    Route::get('/survei/buat', CreateSurvey::class)->name('survey.create');
    Route::get('/survei', OverviewSurveyAdmin::class)->name('survey');
    Route::get('/survei/detail/{surveyID}', DetailSurvey::class)->name('survey.detail');


    // untuk mengisi survei
    Route::get('/survei/isi', FillSurvey::class)->name('survey.fill.overview');
    Route::get('/survei/isi/{surveyID}', FillSurveyDetail::class)->name('survey.fill');
    // {surveyID}
    // Route::get('/testing/isi/{surveyID}', TestPersis::class)->name('survey.fill');
    // untuk error
    Route::get('/404', function () {
        return view('errors.404');
    })->name('notfound');

    // untuk nambah option
    Route::get('/tambah-opsi-jawaban', CreateAnswerOptionPage::class)->name('add.option');
});
