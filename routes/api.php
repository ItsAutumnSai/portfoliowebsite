<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Portfolio;
use App\Models\Comment;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Portfolio API routes
Route::get('/portfolios', function () {
    return Portfolio::with(['contents', 'comments.user'])->get();
});

Route::get('/portfolios/{id}', function ($id) {
    return Portfolio::with(['contents', 'comments.user'])->findOrFail($id);
});

Route::post('/portfolios', function (Request $request) {
    $request->validate([
        'title' => 'required|string|max:255',
    ]);

    return Portfolio::create($request->all());
})->middleware('auth:sanctum');

Route::put('/portfolios/{id}', function (Request $request, $id) {
    $portfolio = Portfolio::findOrFail($id);
    $portfolio->update($request->all());
    return $portfolio;
})->middleware('auth:sanctum');

Route::delete('/portfolios/{id}', function ($id) {
    $portfolio = Portfolio::findOrFail($id);
    $portfolio->delete();
    return response()->json(['message' => 'Portfolio deleted']);
})->middleware('auth:sanctum');

// Comments API routes
Route::post('/portfolios/{id}/comments', function (Request $request, $id) {
    $request->validate([
        'comment' => 'required|string|max:1000',
    ]);

    return Comment::create([
        'portfolio_id' => $id,
        'user_id' => auth()->id(),
        'comment' => $request->comment,
    ]);
})->middleware('auth:sanctum');