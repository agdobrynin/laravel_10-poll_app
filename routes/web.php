<?php

use App\Http\Livewire\CreatePoll;
use App\Http\Livewire\PollList;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', PollList::class)->name('polls.list');
Route::get('/polls/create', CreatePoll::class)->name('polls.create');
