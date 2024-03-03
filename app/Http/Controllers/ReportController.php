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
        $batch = 1;
        $ctr = 0;
        foreach($getAllTicket as $ticket){
            $ctr++;
            if($ctr <= 10){
                $data["ticketList"]["batch".$batch][] = [
                    "pbno" => $ticket->Pbno." / ".$ticket->MemberId,
                    "name" => $ticket->Name ." - ". $ticket->Branch,
                    "ticketNo" => "ON-".sprintf('%04d', $ticket->ticketNo),
                    "contact" => $ticket->Contact
                ];
            }else{
                $ctr = 0;
                $batch++;
            }
        }

        return response()->make(view('Report.PrintTicket',$data), '200', 
        [
            'Content-Type'=>'application/pdf',
            'Content-Disposition'=>'inline; filname="ticketsPrinting.pdf"'
        ]);
    }
}
