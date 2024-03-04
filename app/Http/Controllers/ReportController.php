<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

//Model
use App\Models\TicketsModel;
use App\Models\VotesModel;
use App\Models\PositionsModel;
use App\Models\CandidateModel;

class ReportController extends Controller
{
    protected $data, $ticketModel, $votesModel, $positionsModel, $candidateModel;

    public function __construct()
    {
        $this->middleware('admin');
        $this->ticketModel = new TicketsModel();
        $this->votesModel = new VotesModel();
        $this->positionsModel = new PositionsModel();
        $this->candidateModel = new CandidateModel();
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
}
