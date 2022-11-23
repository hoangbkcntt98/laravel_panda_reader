<?php

use App\Http\Controllers\AdverbController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\GrammarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KanjiController;
use App\Http\Controllers\MakeHTMLController;
use App\Http\Controllers\SpreadsheetReaderController;
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

Route::middleware('auth')->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('google/login', '\App\Http\Controllers\GoogleController@getAuthUrl')->name('auth.google');
Route::get('auth/google/callback', '\App\Http\Controllers\GoogleController@postLogin');

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
