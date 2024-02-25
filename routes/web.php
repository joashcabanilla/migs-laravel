<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AdminController;

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

//MIGS Verifier Landing Page
Route::middleware(['guest'])->group(
    function (){
        //get route
        Route::get('/', [GuestController::class, 'GetVerifier'])->name('migs.verifier');
        Route::get('/login', [GuestController::class, 'Login'])->name('admin.login');

        //post route
        Route::post('Verifymember', [GuestController::class, 'VerifyMember']);
        Route::post('Verifymember', [GuestController::class, 'VerifyMember']);
        Route::post('Nonmigschangestatus', [GuestController::class, 'Nonmigschangestatus']);
        Route::post('Login', [GuestController::class, 'PostLogin']);
    }
);

//member
Route::prefix('member')->middleware(['authMember','member'])->group(
    function (){
        Route::get('/', [MemberController::class, 'MemberPage'])->name('member.index');
    }
);

//admin
Route::prefix('admin')->middleware(['auth','admin'])->group(
    function (){
        //get route

        //Admin Page Index
        Route::get('/', [AdminController::class, 'AdminPage'])->name('admin.index');

        //Admin Url
        Route::get('/maintenance', [AdminController::class, 'Maintenance'])->name('admin.maintenance');
        Route::get('/user', [AdminController::class, 'User'])->name('admin.user');

        //Utility Url
        Route::get('/utility/dashboard', [AdminController::class, 'UtilityDashboard'])->name('utility.dashboard');
        Route::get('/utility/status', [AdminController::class, 'UtilityStatus'])->name('utility.status');
        Route::get('/utility/member', [AdminController::class, 'UtilityMemberInfo'])->name('utility.member');
        Route::get('/utility/verification', [AdminController::class, 'UtilityVerification'])->name('utility.verification');

        //Election Url
        Route::get('/election/position', [AdminController::class, 'ElectionPosition'])->name('election.position');
        Route::get('/election/candidate', [AdminController::class, 'ElectionCandidate'])->name('election.candidate');

        //post route
        //admin post route
        Route::post('Logout', [AdminController::class, 'PostLogout']);
        Route::post('BatchInsertData', [AdminController::class, 'BatchInsertData']);
        Route::post('UserDataTable', [AdminController::class, 'UserDataTable']);
        Route::post('CreateUpdateUser', [AdminController::class, 'CreateUpdateUser']);
        Route::post('GetUser', [AdminController::class, 'GetUser']);

        //utility post route
        Route::post('GetUtilityDashboardData', [AdminController::class, 'GetUtilityDashboardData']);
        Route::post('MemberDataTable', [AdminController::class, 'MemberDataTable']);
        Route::post('AddMember', [AdminController::class, 'AddMember']);
        Route::post('GetMember', [AdminController::class, 'GetMember']);
        Route::post('UpdateMember', [AdminController::class, 'UpdateMember']);
        Route::post('MemberStatusDataTable', [AdminController::class, 'MemberStatusDataTable']);
        Route::post('UpdateMemberStatus', [AdminController::class, 'UpdateMemberStatus']);
        Route::post('VerificationDataTable', [AdminController::class, 'VerificationDataTable']);
        Route::post('AddMemberVerification', [AdminController::class, 'AddMemberVerification']);
        Route::post('UpdateMemberVerification', [AdminController::class, 'UpdateMemberVerification']);

        //election post route
        Route::post('ElectionPositionDataTable', [AdminController::class, 'ElectionPositionDataTable']);
        Route::post('GetElectionPosition', [AdminController::class, 'GetElectionPosition']);
        Route::post('AddUpdateElectionPosition', [AdminController::class, 'AddUpdateElectionPosition']);
    }
);

