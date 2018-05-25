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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'pengelola'], function () {
  Route::get('/login', 'PengelolaAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'PengelolaAuth\LoginController@login');
  Route::post('/logout', 'PengelolaAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'PengelolaAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'PengelolaAuth\RegisterController@register');


  Route::post('/password/email', 'PengelolaAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'PengelolaAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'PengelolaAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'PengelolaAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'pengguna'], function () {
  Route::get('/login', 'PenggunaAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'PenggunaAuth\LoginController@login');
  Route::post('/logout', 'PenggunaAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'PenggunaAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'PenggunaAuth\RegisterController@register');
  Route::post('/register/check_email', 'PenggunaAuth\RegisterController@check_email');


  Route::post('/password/email', 'PenggunaAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'PenggunaAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'PenggunaAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'PenggunaAuth\ResetPasswordController@showResetForm');
  Route::post('/singkatan/ajukan', 'PenggunaAuth\SingkatanController@ajukan_singkatan')->name('singkatan.ajukan');
  Route::post('/singkatan/daftar_pengajuan_singkatan', 'PenggunaAuth\SingkatanController@allPengajuanSingkatan')->name('singkatan.daftar_pengajuan_singkatan');
  Route::post('/singkatan/batalkan_pengajuan', 'PenggunaAuth\SingkatanController@batalkan_pengajuan')->name('singkatan.batalkan_pengajuan');
  Route::post('/kritik_saran/kirim', 'PenggunaAuth\KritikSaranController@kirim_kritik_saran')->name('kritik_saran.kirim');
  Route::post('/pengenalan/upload', 'PenggunaAuth\UploadSampelGambarController@upload_sampel_gambar')->name('pengenalan.upload');

Route::post('/pengenalan/convert_to_binary_image', 'PenggunaAuth\PengenalanController@convert_to_binary_image')->name('pengenalan.convert_to_binary_image');

  
  
});
