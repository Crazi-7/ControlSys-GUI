<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [HomeController::class, 'index'])->name("index");;



Route::middleware('auth')->group(function () {
   
    //pages -------------------------------
        Route::get('/home', [PageController::class, 'home'])->name("home"); // view all projects
        
        Route::get('/profile', [PageController::class, 'profile'])->name("profile"); //view profile
        Route::get('/profile/{field}', [PageController::class, 'update']); //update specific field

    //create project ----------------------------
        Route::get('/project', [ProjectsController::class, 'index'])->name("newproject");
        Route::post('/project', [ProjectsController::class, 'create']);

    // exisitng project --------------------------
        Route::get('/project/{id}', [ProjectsController::class, 'gui'])->name("gui"); //main gui page
       Route::get('/projects/simulate', [ProjectsController::class, 'simulate']); //simulation test page

        Route::get('/project/{id}/edit', [ProjectsController::class, 'edit'])->name("editp"); //edit project details
        Route::post('/project/{id}/edit', [ProjectsController::class, 'update']);

        Route::get('/project/{id}/delete', [ProjectsController::class, 'delete']); //delete project

}); //protected routes by login
Route::get('/projects/simple', [ProjectsController::class, 'simple'])->name("simple"); //edit project details
Route::get('/gui/a', [ProjectsController::class, 'guie'])->name("guiEngine");
Route::get('/design', [ProjectsController::class, 'design'])->name("design");
//registration ----------------
    Route::get('/register', [LoginController::class, 'register'])->name("register");
    Route::post('/register', [LoginController::class, 'save']);

//login -----------------------
    Route::get('/login', [LoginController::class, 'index'])->name("login");
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/logout', [LoginController::class, 'logout'])->name("logout");









/*
Route::get('/', [OrganizersController::class, 'index']);
Route::post('/', [LoginController::class, 'login']);



//logged in routes

Route::get('/events', [EventsController::class, 'index'])->name('events');
Route::get('/event/{id}', [EventsController::class, 'show'])->name('showEvent');
Route::get('/event/{id}/edit', [EventsController::class, 'edit'])->name('editEvent');
*/
