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



Auth::routes();

Route::get('/avatar', 'UsersController@avatar')->name('avatar');

Route::middleware('auth')->group(function() {

  Route::middleware('lock')->group(function() {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@index');

    Route::prefix('admin')->group(function() {

      Route::resource('contas', 'ContaController');
      Route::resource('financeiro', 'FinanceiroController');
      Route::resource('contatos', 'ContatoController');
      Route::resource('movimentos', 'MovimentosController');
      Route::resource('categorias', 'CategoriasController');
      Route::resource('grupos', 'GruposController');

      Route::resource('condominio', 'CondominioController');

      Route::get('/images/external', 'MovimentosController@images')->name('images');
      Route::post('/movimentos/{id}/pagar', 'MovimentosController@pagar')->name('movimento_pagar');

      Route::get('/info', 'FinanceiroController@info')->name('informacoes_financeiras');
      Route::get('/grafico', 'FinanceiroController@grafico')->name('grafico');

    });

  });

  Route::get('lockscreen', 'LockAccountController@lockscreen')->name('lockscreen');
  Route::post('lockscreen', 'LockAccountController@unlock')->name('post_lockscreen');

});
