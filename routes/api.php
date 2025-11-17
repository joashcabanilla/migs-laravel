<?php

use Illuminate\Support\Facades\Route;

//Controllers
use App\Http\Controllers\DataController;

//import data route
Route::post("import", [DataController::class, "import"]);