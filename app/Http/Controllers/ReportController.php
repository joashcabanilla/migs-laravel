<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

//Model
use App\Models\TicketsModel;
use App\Models\VotesModel;
use App\Models\VotersModel;
use App\Models\PositionsModel;
use App\Models\CandidateModel;
use App\Models\GaItemsModel;
use App\Models\User;

class ReportController extends Controller
{
    protected $data, $ticketModel, $votesModel, $positionsModel, $candidateModel, $gaItemsModel, $userModel, $voterModel;

    public function __construct()
    {
        $this->middleware('admin');
        $this->ticketModel = new TicketsModel();
        $this->votesModel = new VotesModel();
        $this->positionsModel = new PositionsModel();
        $this->candidateModel = new CandidateModel();
        $this->gaItemsModel = new GaItemsModel();
        $this->voterModel = new VotersModel();
        $this->userModel = new User();
    }

    function PrintTickets(Request $request){
        $var = (object) $request->all();
        $data = array();
        $getAllTicket = $this->ticketModel->dataTable($var)->get();

        foreach($getAllTicket as $ticket){
            $memId = !empty($ticket->MemberId) ? $ticket->MemberId : "NO MEM ID";
            $pbno = !empty($ticket->Pbno) ? $ticket->Pbno : "NO PB#";

            $data["ticketList"][] = [
                "pbno" => $memId ." / ". $pbno,
                "name" => $ticket->Name,
                "ticketNo" => "ON-".sprintf('%04d', $ticket->ticketNo),
                "contact" => $ticket->Contact
            ];
        }

        return response()->make(view('Report.PrintTicket',$data), '200', 
        [
            'Content-Type'=>'application/pdf',
            'Content-Disposition'=>'inline; filname="ticketsPrinting.pdf"'
        ]);
    }

    function PrintSummary(Request $request){
        $var = (object) $request->all();
        $data = $positionList = $voteList = array();
        $getAllVotes = $this->votesModel->dataTable($var)->get();
        $positions = $this->positionsModel->GetPositionList();
        $candidates = $this->candidateModel->GetAllCandidate();
        
        foreach($positions as $position){
            $positionList[$position->Id] = $position->Description;
        }

        if(!empty($getAllVotes)){
            foreach($getAllVotes as $votes){
                $voteList[strtoupper($votes->Candidate)][] = $votes->VoterId;
            }
        }

        foreach($candidates as $candidate){
            $name = strtoupper($candidate["FirstName"] . " " . $candidate["MiddleName"] . " " . $candidate["LastName"]);
            if(isset($voteList[$name])){
                $data["votesTally"][$positionList[$candidate["Position"]]][$name] = $voteList[$name];
            }else{
                $data["votesTally"][$positionList[$candidate["Position"]]][$name] = 0;
            }
        }

        $data["DateTime"] = date("F d, Y h:i A", strtotime(Carbon::now()));
        
        return response()->make(view('Report.ElectionSummary',$data), '200', 
        [
            'Content-Type'=>'application/pdf',
            'Content-Disposition'=>'inline; filname="ElectionSummary.pdf"'
        ]);
    }

    function PrintSummaryGaItems(Request $request){
        $var = (object) $request->all();
        $data = array();
        $voterList = $this->votesModel->GetAllVotePerVoteMethod($var->voteMethod);
        $gaItemList = $this->gaItemsModel->SummaryReport($var);
        $users = $this->userModel->GetUserListNotMember();

        $userList = $voterIdList = $voteMethodList = $memberReceivedList = $branchUserList = array();
        
        foreach($users as $user){
            $userList[$user->Id] = strtoupper(str_replace('ñ', 'Ñ', $user->FirstName . " " . $user->LastName)); 
            $branchUserList[strtoupper(str_replace('ñ', 'Ñ', $user->FirstName . " " . $user->LastName))] = $user->Branch;
        }

        foreach($voterList as $voter){
            $voteMethodList[$voter->VoterId] = $voter->VoteF2F == "NO" ? "ONLINE" : "FACE TO FACE";
        }

        foreach($gaItemList as $item){
            $voterIdList[] = $item->VoterId;
        }

        if(!empty($voterIdList)){
            $voters = $this->voterModel->memberReceivedItems($voterIdList)->get();
            foreach($voters as $voter){
                $memberReceivedList[$voter->Id] = [
                    "Pbno" => $voter->Pbno,
                    "MemberId" => $voter->MemberId,
                    "Name" => $voter->Name,
                ];
            }
        }
        
        $data["memberList"] = $data["SummaryReport"] = array();

        foreach($gaItemList as $item){
            if(isset($voteMethodList[$item->VoterId])){
                $data["memberList"][] = [
                    "Pbno" => $memberReceivedList[$item->VoterId]["Pbno"],
                    "MemberId" => $memberReceivedList[$item->VoterId]["MemberId"],
                    "Name" => $memberReceivedList[$item->VoterId]["Name"],
                    "RegisterBy" => $userList[$item->RegisterBy],
                    "DateTime" => date("m/d/Y", strtotime($item->created_at)),
                    "VoteMethod" => $voteMethodList[$item->VoterId],
                ]; 
            }
        }

        if($var->reportType == "1"){
            $data["encoderName"] = $userList[Auth::user()->Id];
            
            return response()->make(view('Report.GaItemsSummaryPerUser',$data), '200', 
            [
                'Content-Type'=>'application/pdf',
                'Content-Disposition'=>'inline; filname="GaItemsSummaryPerUser.pdf"'
            ]);
            
        }else if($var->reportType == "2"){
            $data["branchUserList"] = $branchUserList;
            $data["DateTime"] = empty($var->date) ? date("m/d/Y") : date("m/d/Y", strtotime($var->date)); 
            if(!empty($data["memberList"])){
                foreach($data["memberList"] as $member){
                    $data["SummaryReport"][$member["RegisterBy"]][$member["VoteMethod"]][$member["DateTime"]][] = $member;
                }
            }
            return response()->make(view('Report.GaItemsSummary',$data), '200', 
            [
                'Content-Type'=>'application/pdf',
                'Content-Disposition'=>'inline; filname="GaItemsSummary.pdf"'
            ]);

        }else{
            $data["DateTime"] = empty($var->date) ? date("m/d/Y") : date("m/d/Y", strtotime($var->date)); 
            $data["electionSummary"] = $this->votesModel->GetElectionSummary($var->voteMethod,$var->date);

            return response()->make(view('Report.ElectionSummaryPerMember',$data), '200', 
            [
                'Content-Type'=>'application/pdf',
                'Content-Disposition'=>'inline; filname="ElectionSummary.pdf"'
            ]);
        }
        
    }
}
