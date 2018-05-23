<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('pengelola')->user();

    //dd($users);

    return view('pengelola.home');
})->name('home');

