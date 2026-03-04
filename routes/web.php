<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;

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
        Route::get('/voter', [GuestController::class, 'Voter'])->name('voter.login');
        Route::get('/electionClosed', [GuestController::class, 'ElectionClosed'])->name('election.closed');
        Route::get('xmTQgFpQmzR9ixHIYfZS',[GuestController::class, 'ElectionLive'])->name('election.live');
        Route::get('dashboard',[GuestController::class, 'DashboardLive'])->name('dashboard.live');

        //post route
        Route::post('Verifymember', [GuestController::class, 'VerifyMember']);
        Route::post('Nonmigschangestatus', [GuestController::class, 'Nonmigschangestatus']);
        Route::post('Login', [GuestController::class, 'PostLogin']);
        Route::post('SetVoterId', [GuestController::class, 'SetVoterId']);
        Route::post('VoterLogin', [GuestController::class, 'VoterLogin']);
        Route::post('ElectionAuthentication', [GuestController::class, 'ElectionAuthentication']);
        Route::post('ResendOtp', [GuestController::class, 'ResendOtp']);
        Route::post('ElectionLiveData', [GuestController::class, 'ElectionLiveData']);
    }
);

//member
Route::prefix('member')->middleware(['authMember','member'])->group(
    function (){
        //get route
        Route::get('/', [MemberController::class, 'MemberPage'])->name('member.index');
        Route::get('/voting', [MemberController::class, 'Voting'])->name('member.voting');

        //post route
        Route::post('Logout', [MemberController::class, 'PostLogout']);
        Route::post('SubmitVote', [MemberController::class, 'SubmitVote']);
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
        Route::get('/election/dashboard', [AdminController::class, 'ElectionDashboard'])->name('election.dashboard');
        Route::get('/election/position', [AdminController::class, 'ElectionPosition'])->name('election.position');
        Route::get('/election/candidate', [AdminController::class, 'ElectionCandidate'])->name('election.candidate');
        Route::get('/election/tickets', [AdminController::class, 'ElectionTickets'])->name('election.tickets');
        Route::get('/election/summary', [AdminController::class, 'ElectionSummary'])->name('election.summary');

        //Supplies Url
        Route::get('/supplies', [AdminController::class, 'Supplies'])->name('supplies.index');

        //F2F Election Url
        Route::get('/F2Felection', [AdminController::class, 'F2Felection'])->name('F2Felection.index');
        Route::get('/F2Fvoting', [AdminController::class, 'F2Fvoting'])->name('F2Fvoting.index');

        //post route
        //admin post route
        Route::post('Logout', [AdminController::class, 'PostLogout']);
        Route::post('BatchInsertData', [AdminController::class, 'BatchInsertData']);
        Route::post('UserDataTable', [AdminController::class, 'UserDataTable']);
        Route::post('CreateUpdateUser', [AdminController::class, 'CreateUpdateUser']);
        Route::post('GetUser', [AdminController::class, 'GetUser']);
        Route::post('UpdateElectionStatus', [AdminController::class, 'UpdateElectionStatus']);

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
        Route::post('GetElectionDashboardData', [AdminController::class, 'GetElectionDashboardData']);
        Route::post('ElectionPositionDataTable', [AdminController::class, 'ElectionPositionDataTable']);
        Route::post('GetElectionPosition', [AdminController::class, 'GetElectionPosition']);
        Route::post('AddUpdateElectionPosition', [AdminController::class, 'AddUpdateElectionPosition']);

        Route::post('ElectionCandidateDataTable', [AdminController::class, 'ElectionCandidateDataTable']);
        Route::post('GetElectionCandidate', [AdminController::class, 'GetElectionCandidate']);
        Route::post('AddUpdateElectionCandidate', [AdminController::class, 'AddUpdateElectionCandidate']);

        Route::post('ElectionTicketDataTable', [AdminController::class, 'ElectionTicketDataTable']);
        Route::post('PrintTickets', [ReportController::class, 'PrintTickets'])->name('print.ticket');
        Route::post('ElectionSummaryDataTable', [AdminController::class, 'ElectionSummaryDataTable']);
        Route::post('PrintSummary', [ReportController::class, 'PrintSummary'])->name('print.summary');
        
        //supplies post route
        Route::post('SuppliesDataTable', [AdminController::class, 'SuppliesDataTable']);
        Route::post('ReceivedGaItems', [AdminController::class, 'ReceivedGaItems']);
        Route::post('GetMemberGaItems', [AdminController::class, 'GetMemberGaItems']);
        Route::post('PrintSummaryGaItems', [ReportController::class, 'PrintSummaryGaItems'])->name('print.summaryGaItems');

        //F2F Election post route
        Route::post('f2fDataTable', [AdminController::class, 'f2fDataTable']);
        Route::post('f2fSubmitVote', [AdminController::class, 'f2fSubmitVote']);
        Route::post('f2fGenerateReport', [ReportController::class, 'f2fGenerateReport'])->name('print.f2f');
    }
);
