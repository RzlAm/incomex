<?php

use Illuminate\Support\Facades\Route;

Route::get('/statistics/export-csv', [\App\Filament\Pages\Statistics::class, 'exportCSV'])->middleware('auth')->name('statistics.export.csv');
