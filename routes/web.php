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
      Route::resource('blocos', 'BlocosController');

      Route::resource('condominio', 'CondominioController');

      Route::resource('relatorios', 'RelatoriosController');
      Route::resource('orcamentos', 'OrcamentosController');
      Route::get('orcamentos/create/finish', 'OrcamentosController@finish')->name('orcamento_create_finish');
      Route::get('orcamentos/{id}/categorias', 'OrcamentosController@categorias')->name('orcamento_categorias');

      Route::get('/images/external', 'MovimentosController@images')->name('images');
      Route::post('/movimentos/{id}/pagar', 'MovimentosController@pagar')->name('movimento_pagar');

      Route::get('/info', 'FinanceiroController@info')->name('informacoes_financeiras');
      Route::get('/grafico', 'FinanceiroController@grafico')->name('grafico');

      Route::post('/contato/store/ajax', 'ContatoController@storeAjax')->name('contato_store_ajax');

    });

  });

  Route::get('lockscreen', 'LockAccountController@lockscreen')->name('lockscreen');
  Route::post('lockscreen', 'LockAccountController@unlock')->name('post_lockscreen');

});
