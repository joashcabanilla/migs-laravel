<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $result["createTicket"] = "YES";

        $forChecking = (object) $validation;
        
        if($forChecking->electionStatus == "open" || $forChecking->f2fElectionStatus == "open"){
            $f2f = $forChecking->f2fElectionStatus == "open" ? "YES" : "NO";

            if(!empty($data)){
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

            $result["status"] = "success";
            $result["message"] = "Successfully Voted.";
            if($f2f == "YES"){
                $result["createTicket"] = "NO";
            }
        }

        return $result;
    }
}
