<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdverbController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\GrammarController;
use App\Http\Controllers\KanjiController;
use App\Http\Controllers\MakeHTMLController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VocabularyController;
use App\Http\Controllers\WordFormationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('home');
});

Route::middleware('auth')->get('/home', [App\Http\Contro\llers\HomeController::class, 'index'])->name('home');

Route::get('google/login', [GoogleController::class, 'getAuthUrl'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'postLogin']);

Route::middleware('auth')->get('vocabulary', [VocabularyController::class, 'index'])->name('vocabulary');
Route::middleware('auth')->get('vocabulary_sync', [VocabularyController::class, 'sync'])->name('vocabulary.sync');

Route::middleware('auth')->get('adverb', [AdverbController::class, 'index'])->name('adverb');
Route::middleware('auth')->get('adverb_sync', [AdverbController::class, 'sync'])->name('adverb.sync');

Route::middleware('auth')->get('word_formation', [WordFormationController::class, 'index'])->name('word_formation');
Route::middleware('auth')->get('word_formation_sync', [WordFormationController::class, 'sync'])->name('word_formation.sync');

Route::middleware('auth')->get('grammar', [GrammarController::class, 'index'])->name('grammar');
Route::middleware('auth')->get('grammar_sync', [GrammarController::class, 'sync'])->name('grammar.sync');

Route::middleware('auth')->get('kanji', [KanjiController::class, 'index'])->name('kanji');
Route::middleware('auth')->get('kanji_sync', [KanjiController::class, 'sync'])->name('kanji.sync');

Route::middleware('auth')->get('review_html', [MakeHTMLController::class, 'index'])->name('html.review');
Route::middleware('auth')->get('make_html', [MakeHTMLController::class, 'make'])->name('html.make');

Auth::routes();

Route::middleware('auth')->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Notifications
Route::get(
    'notifications/get',
    [NotificationController::class, 'get']
)->name('notifications.get');


Route::get(
    'notifications/read/{id}',
    [NotificationController::class, 'read']
)->name('notifications.read');

Route::get(
    'notifications/delete/{id}',
    [NotificationController::class, 'delete']
)->name('notifications.delete');

Route::get(
    'notifications/marked/{id}',
    [NotificationController::class, 'marked']
)->name('notifications.marked');

Route::get(
    'notifications/show',
    [NotificationController::class, 'show']
)->name('notifications.show');

Route::get(
    'profile/{id}',
    [AccountController::class, 'profile']
);

// Documents

Route::get(
    'documents',
    [DocumentController::class, 'index']
)->name('documents.index');


Route::post(
    'documents.store',
    [DocumentController::class, 'store']
)->name('documents.store');

Route::get(
    'documents/{id}/delete',
    [DocumentController::class, 'delete']
)->name('documents.delete');

Route::post(
    'documents/{id}/edit',
    [DocumentController::class, 'edit']
)->name('documents.edit');

//Materials

Route::get(
    'materials/{id}',
    [MaterialController::class, 'get']
);
Route::get(
    'materials/{id}/sync',
    [MaterialController::class, 'sync']
);

Route::get(
    'materials.create',
    [MaterialController::class, 'create']
)->name('materials.create');

Route::post(
    'materials.store',
    [MaterialController::class, 'store']
)->name('materials.store');

Route::get(
    'materials/{id}/make_html',
    [MaterialController::class, 'makeHtml']
)->name('materials.makeHtml');
