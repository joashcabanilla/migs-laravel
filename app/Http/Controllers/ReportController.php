<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Model
use App\Models\TicketsModel;

class ReportController extends Controller
{
    protected $data, $ticketModel;

    public function __construct()
    {
        $this->middleware('admin');
        $this->ticketModel = new TicketsModel();
        $this->data = array();
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
}
