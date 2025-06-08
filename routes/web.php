<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();
Route::view('/', 'auth.login');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/profile', 'UserController@profile')->name('admin.profile');
//Route::get ('/beto', [App\Http\Controllers\BetoController::class, 'index'])->name('beto');
//Route::post('/beto', [App\Http\Controllers\BetoController::class, 'func1'])->name('beto');

//Route::get ('/beto2', [App\Http\Controllers\Beto2Controller::class, 'index'])->name('beto2');
//Route::post('/beto2', [App\Http\Controllers\Beto2Controller::class, 'func1'])->name('beto2');

Route::resource ('emissor', App\Http\Controllers\EmissorController::class);
Route::resource ('grupo', App\Http\Controllers\GrupoController::class);

Route::resource ('assinatura', App\Http\Controllers\AssinaturaController::class);
Route::resource ('assunto', App\Http\Controllers\AssuntoController::class);
Route::resource ('aplicacao', App\Http\Controllers\AplicacaoController::class);
Route::resource ('usuario_aplicacao', App\Http\Controllers\Usuario_AplicacaoController::class);



Route::view('usage', 'usage');

Route::post('/image/upload', [App\Http\Controllers\ImageController::class, 'upload'])->name('image.upload');
