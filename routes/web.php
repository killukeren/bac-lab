<?php

use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));
Route::get('/profile/{id}', fn($id) => view('dashboard.profile', compact('id')));
Route::get('/login', fn() => view('auth.login'));
Route::get('/register', fn() => view('auth.register'));
Route::get('/dashboard', fn() => view('dashboard.index'));
Route::get('/groups', fn() => view('groups.index'));
Route::get('/groups/{id}/chat', fn($id) => view('groups.chat', compact('id')));
