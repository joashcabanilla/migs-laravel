<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VotesModel extends Model
{
    use HasFactory;
    protected $table = 'votes';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'VoterId',
        'Candidate',
        'VoteF2F',
    ];

    function CheckVote($voterId){
        return $this->where("VoterId",$voterId)->count();
    }
    
    function SubmitVote($data, $voterId, $validation){
        $result = array();
        $result["status"] = "election closed";
        $result["message"] = "Election has already closed.";
        
        $forChecking = (object) $validation;
        
        if($forChecking->electionSetting != "OPEN"){
            return $result;
        }
        
        $f2f = strtoupper(config('app.F2F_ELECTION'));
        $memberCheck = $this->where("VoterId",$voterId)->first();
        if(empty($memberCheck) && $forChecking->electionSetting == "OPEN"){
            if(!empty($data) && count($data) > 1){
                $var = (object) $data;
                foreach($var->candidateId as $candidateId){
                    $this->create([
                        "VoterId" => $voterId,
                        "Candidate" => $candidateId,
                        "VoteF2F" => $f2f
                    ]);
                }
            }else{
                $this->create([
                    "VoterId" => $voterId,
                    "Candidate" => 0,
                    "VoteF2F" => $f2f
                ]);
            }
        }
        

        $result["status"] = "success";
        $result["message"] = "Successfully Voted.";

        return $result;
    }

    function GetVote($voterId){
        return $this->where("VoterId", $voterId)->get();
    }

    function GetAllVotersVoted($nonVoting = false){
        if($nonVoting){
            return $this->select("VoterId")->where("Candidate", 0)->groupBy("VoterId")->get();
        }
        return $this->select("VoterId","VoteF2F")->groupBy("VoterId","VoteF2F")->get();
    }

    function GetAllVotePerCandidate(){
        return $this->get();
    }

    function GetAllVotePerVoteMethod($method){
        $query = $this->select("VoterId","VoteF2F")->groupBy("VoterId","VoteF2F");
        
        if(!empty($method)){
            $f2f = $method == "online" ? "NO" : "YES";
            $query = $query->where("VoteF2F",$f2f);
        } 
        
        return $query->get();
    }

    function dataTable($data){
        $query = $this->select(
            "votes.Id AS Id",
            "votes.VoterId AS VoterId",
            DB::raw("CONCAT(COALESCE(candidates.FirstName, ''), ' ', COALESCE(candidates.MiddleName, ''), ' ', COALESCE(candidates.LastName, '')) AS Candidate"),
            "votes.VoteF2F AS VoteMethod",
            "votes.created_at AS DateTime",
            "candidates.Position"
        )->join("candidates","candidates.Id","votes.Candidate");

        if(!empty($data->filterSearch)){
            $search = strtoupper(str_replace('ñ', 'Ñ', $data->filterSearch));
            $query->where(function($q) use($search){
                $q->orWhereRaw("CONCAT(COALESCE(candidates.FirstName, ''), ' ', COALESCE(candidates.MiddleName, ''), ' ', COALESCE(candidates.LastName, '')) LIKE '%".$search."%'");
                $q->orWhereRaw("votes.VoterId LIKE '%".$search."%'");
            });
        }

        $query = !empty($data->filterCandidate) ? $query->where("votes.Candidate",$data->filterCandidate) : $query;
        $query = !empty($data->filterPosition) ? $query->where("candidates.Position",$data->filterPosition) : $query;

        $query = $query->orderBy("votes.Id", "ASC");
        return $query;
    }

    function GetElectionSummary($method, $date, $notReceivedIdList = array()){
        $query = $this->select("VoterId","VoteF2F","created_at")->groupBy("VoterId","VoteF2F","created_at");

        if(!empty($method)){
            $f2f = $method == "online" ? "NO" : "YES";
            $query = $query->where("VoteF2F",$f2f);
        } 

        if(!empty($date)){
            $dateFrom = date("Y-m-d", strtotime($date));
            $dateTo = date("Y-m-d", strtotime($date . " +1 day"));
            $query = $query->whereBetween("created_at",[$dateFrom." 7:00:00",$dateTo." 7:00:00"]);
        } 

        if(!empty($notReceivedIdList)){
            $query = $query->WhereIn("VoterId",$notReceivedIdList);
        }

        $query = $query->get();
        $votesData = $voterIdList = $electionSummary = array();

        if(!empty($query)){
            foreach($query as $vote){
                if(!array_search($vote->VoterId,$voterIdList)){
                    $voterIdList[] = $vote->VoterId;

                    $votesData[$vote->VoterId] = [
                        "voteMethod" => $vote->VoteF2F == "NO" ? "ONLINE" : "FACE TO FACE",
                        "dateTime" => date("m/d/Y",strtotime($vote->created_at)),
                    ];
                }
            }
    
            $voters = DB::table("voters")->select(
                "Id",
                "Pbno",
                "MemberId",
                DB::raw("CONCAT(COALESCE(FirstName, ''), ' ', COALESCE(MiddleName, ''), ' ', COALESCE(LastName, '')) AS Name"),
                "Branch"
            )->whereIn("Id",$voterIdList)->get();
    
            foreach($voters as $voter){
                $votesData[$voter->Id]["pbno"] = $voter->Pbno;
                $votesData[$voter->Id]["memberId"] = $voter->MemberId;
                $votesData[$voter->Id]["name"] = $voter->Name;
                $votesData[$voter->Id]["branch"] = $voter->Branch;
                $electionSummary[$voter->Id] =  $votesData[$voter->Id];
            } 

            usort($electionSummary, function($a, $b) {
                if ($a['branch'] == $b['branch']) {
                    if ($a['voteMethod'] == $b['voteMethod']) {
                        return strtotime($a['dateTime']) - strtotime($b['dateTime']);
                    }
                    return strcmp($a['voteMethod'], $b['voteMethod']);
                }
                return strcmp($a['branch'], $b['branch']);
            });
        }

        return $electionSummary;
    }
}