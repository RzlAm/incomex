<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/app');
});

Route::get('/schedule-tutor', function () {
    return view('schedule-tutor');
});
