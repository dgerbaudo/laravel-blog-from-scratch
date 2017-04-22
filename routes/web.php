<?php

use Illuminate\Support\Facades\DB;
use App\Task;

Route::get('/tasks', 'TasksController@index');
Route::get('/tasks/{task}', 'TasksController@show');
