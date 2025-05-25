<?php

use Dynamik\DbChart\Controllers\DbChartController;
use Illuminate\Support\Facades\Route;

Route::get(config('db-chart.route'), [DbChartController::class, 'index'])->name('db-chart');
