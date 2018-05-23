<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('pengguna')->user();

    //dd($users);

    return view('pengguna.home');
})->name('home');

