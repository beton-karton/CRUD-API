<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PokemonController;
use App\Http\Controllers\Api\SkillsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('pokemons', PokemonController::class);
Route::get('/pokemons/{id}/image', [PokemonController::class, 'getImage']);

Route::prefix('/pokemons/{id}/skills')->group(function () {
    Route::get('/', function () {
        Route::get('', [SkillsController::class, 'getSkills']);
        Route::post('', [SkillsController::class, 'addSkill']);
        Route::get('/{skill_id}', [SkillsController::class, 'showSkill']);
        Route::put('/{skill_id}', [SkillsController::class, 'updateSkill']);
        Route::delete('/{skill_id}', [SkillsController::class, 'deleteSkill']);
        Route::get('/{skill_id}/image', [SkillsController::class, 'getImage']);
    });
});
