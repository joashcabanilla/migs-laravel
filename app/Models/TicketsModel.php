<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketsModel extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'Id',
        'VoterId',
    ];

    function CreateTicket($voterId,$validation){
        $forChecking = (object) $validation;
        if($forChecking->electionStatus == "open" || $forChecking->f2fElectionStatus == "open"){
            if(strtoupper(config('app.F2F_ELECTION')) == "NO"){
                return $this->create([
                    "VoterId" => $voterId
                ]);
            }
        }
    }

    function GetTicketNo($voterId){
        $ticketNo = "";
        $ticket = $this->where("VoterId",$voterId)->first();

        if(!empty($ticket)){
            $ticketNo = "ON-".sprintf('%04d', $ticket->Id);
        }

        return $ticketNo;
    }
}
