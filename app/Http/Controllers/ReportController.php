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
            $data["ticketList"][$ticket->Branch][$ticket->Name] = $ticket->ticketNo;
        }

        return response()->make(view('Report.PrintTicket',$data), '200', 
        [
            'Content-Type'=>'application/pdf',
            'Content-Disposition'=>'inline; filname="ticketsPrinting.pdf"'
        ]);
    }
}
