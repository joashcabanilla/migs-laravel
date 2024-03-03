<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

//Model
use App\Models\VotersModel;
use App\Models\VotesModel;
use App\Models\PositionsModel;
use App\Models\CandidateModel;
use App\Models\TicketsModel;
use App\Models\SettingsModel;

//Class
use App\Classes\HelperClass;

class MemberController extends Controller
{
    protected $data, $helper, $votersModel, $votesModel, $positionModel, $candidateModel, $ticketsModel, $settingModel;

    public function __construct()
    {
        $this->middleware('member');
        $this->votersModel = new VotersModel();
        $this->helper = new HelperClass();
        $this->votesModel = new VotesModel();
        $this->positionModel = new PositionsModel();
        $this->candidateModel = new CandidateModel();
        $this->ticketsModel = new TicketsModel();
        $this->settingModel = new SettingsModel();
        $this->data = array();
    }

    //GET Method
    function MemberPage(){
        $this->data["TitlePage"] = "NOVADECI ELECTION";
        return view('Layouts.Member',$this->data);
    }

    function Voting(){
        $voterId = Session::get('VoterId');
        $positionList = $this->positionModel->GetPositionList();
        $candidateArray = $this->candidateModel->GetAllCandidate();
        $positions = $candidateList = $voteLimit = array();
        
        foreach($positionList as $position){
            $positions[$position->Id] = $position->Description; 
            $voteLimit[str_replace(' ', '', $position->Description)] = $position->VoteLimit;
        }

        foreach($candidateArray as $candidate){
            $candidatePosition = $positions[$candidate["Position"]];
            $candidateList[$candidatePosition][] = $candidate;
        }
        
        $this->data["candidateList"] = $candidateList;
        $this->data["voteLimit"] = $voteLimit;

        if($this->votesModel->CheckVote($voterId) > 0){
            $this->data["currentPage"] = "voted";
            $this->data["ticketNo"] = $this->ticketsModel->GetTicketNo($voterId);
            $setting = $this->settingModel->first();
            $this->data["gaSched"] = "( ".$setting->MeetingSched." )";
            $this->data["meetingID"] = $setting->MeetingID;
            $this->data["meetingPass"] = $setting->MeetingPass;
            $this->data["gaDate"] = date("F j, Y", strtotime($setting->f2fEndDateTime));
            
            $votedCandidates = $this->votesModel->GetVote($voterId);
            $votedCandidatesList = array();
            foreach($votedCandidates as $voteCandidate){
                if($voteCandidate->Candidate != 0){
                    $votedCandidatesList[] = $voteCandidate->Candidate;
                }
            }
            $this->data["votedCandidatesList"] = $votedCandidatesList;

            return view('Components.Member.MemberVoted',$this->data);
        }else{
            $this->data["currentPage"] = "voting";
            return view('Components.Member.Voting',$this->data);
        }

    }

    //POST Method
    function PostLogout(Request $request){
        Session::forget('VoterId');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response('logout',200); 
    }

    function SubmitVote(Request $request){
        $voterId = Session::get('VoterId');
        $validation = array();
        $validation["electionStatus"] = $this->helper->CheckElectionStatus();
        $validation["f2fElectionStatus"] = $this->helper->f2fElectionStatus();
        $submitTicket = $this->votesModel->SubmitVote($request->all(),$voterId, $validation);
        $this->ticketsModel->CreateTicket($voterId,$validation);
        return $submitTicket;
    }
}
