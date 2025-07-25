<?php

use Hanafalah\ModuleDisease\Controllers\API\Illness\IllnessController;
use Illuminate\Support\Facades\Route;

Route::apiResource('illness', IllnessController::class)
    ->parameters(['illness' => 'id']);