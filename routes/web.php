<?php

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


Route::get('/', 'QuestionsController@index');

Auth::routes(['verify' => true]);

Route::middleware('verified')->group(
    function () {

        Route::get('/home', 'HomeController@index')->name('home');

        Route::resource('questions', 'QuestionsController')->except(['show', 'index'] );
        //Route::post('questions/{question}/answers', 'AnswersController@store')->name('answers.store');
        Route::resource('questions.answers', 'AnswersController')->except(['create', 'show', 'index']);

        Route::post('/answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept');

        Route::post('/questions/{question}/favorites', 'FavoritesController@store')->name('questions.favorite');
        Route::delete('/questions/{question}/favorites', 'FavoritesController@destory')->name('questions.unfavorite');

        // Singe Action Controller
        Route::post('/questions/{question}/vote', 'VoteQuestionController')->name('questions.vote');

        Route::post('/answers/{answer}/vote', 'VoteAnswerController')->name('answers.vote');
   }
);


Route::get('/questions/{slug}', 'QuestionsController@show')->name('questions.show');
Route::get('/questions', 'QuestionsController@index')->name('questions.index');
Route::get('/questions/{question}/answers', 'AnswersController@index')->name('questions.answers.index');

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
