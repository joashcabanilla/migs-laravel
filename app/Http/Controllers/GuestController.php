<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

//Model
use App\Models\VotersModel;
use App\Models\User;
use App\Models\VerificationModel;
use App\Models\VotesModel;
use App\Models\SettingsModel;
use App\Models\MembersModel;

//Class
use App\Classes\HelperClass;

class GuestController extends Controller
{
    protected $data, $helper, $votersModel, $userModel, $verificationModel, $votesModel, $settingModel, $membersModel;

    public function __construct()
    {
        $this->middleware('guest');
        $this->votersModel = new VotersModel();
        $this->userModel = new User();
        $this->helper = new HelperClass();
        $this->verificationModel = new VerificationModel();
        $this->votesModel = new VotesModel();
        $this->settingModel = new SettingsModel();
        $this->membersModel = new MembersModel();
        $this->data = array();
    }

    //GET Method
    function Login(){
        Session::forget('VoterId');
        $this->data["TitlePage"] = "NOVADECI Login";
        return view('Components.Guest.LoginAdmin',$this->data);
    }

    function GetVerifier(){
        Session::forget('VoterId');
        $settingStatus = (object) $this->helper->CheckSettingStatus();
        $this->data["branchContact"] = $this->helper->BranchContactList();
        $this->data["TitlePage"] = "NOVADECI MIGS Verifier";
        
        if($settingStatus->verifier == "CLOSED"){    
            return view('Components.Guest.ElectionClosed',$this->data);
        }
        return view('Components.Guest.Verifier',$this->data);
    }

    function Voter(){
        if(Session::has('VoterId')){
            $this->data["TitlePage"] = "NOVADECI Election";
            $this->data["VoterId"] = Session::get('VoterId');
            $voter = $this->votersModel->GetMember($this->data["VoterId"]);
            $this->data["Pbno"] = !empty($voter->Pbno) ? $voter->Pbno : $voter->MemberId;
            return view('Components.Guest.VoterLogin',$this->data);
        }else{
            return redirect('/');
        }
    }

    function ElectionClosed(){
        $settingStatus = (object) $this->helper->CheckSettingStatus();
        $dateToday = date("Y-m-d");
        $gaDate = date("Y-m-d", strtotime($settingStatus->gaDate));

        if($settingStatus->election == "OPEN" && $dateToday != $gaDate){
            return redirect('/');
        }
        $this->data["TitlePage"] = "NOVADECI Election";
        return view('Components.Guest.ElectionClosed',$this->data);
    }

    //Post Method
    function VerifyMember(Request $request){
        $searched = $this->votersModel->SearchMember($request->search);
        $result["status"] = "success";
        $result["settingStatus"] = $this->helper->CheckSettingStatus();
        if(count($searched) > 0){
            foreach($searched as $data){
                $result["data"][] = [
                    "id" => $data["Id"],
                    "memid" => !empty($data["MemberId"]) ? $data["MemberId"] : "No Data",
                    "pbno" => !empty($data["Pbno"]) ? $data["Pbno"] : "No Data",
                    "name" => $data["FirstName"]." ".$data["MiddleName"]." ".$data["LastName"],
                    "status" => $data["Status"],
                    "bday" => $data["Birthdate"],
                    "branch" => $data["Branch"],
                ];
            }
            
        }else{
            $result["status"] = "failed";
        }

        return $result;
    }

    function Nonmigschangestatus(Request $request){
        $member = $this->verificationModel->AddMember($request->all());
        $response = (object) $member;
        if($response->status == "success"){
            $this->votersModel->updateContact($request->Id,$request->contact);
        }
        return $member;
    }
    
    function PostLogin(Request $request){
        $tickets = DB::table("tickets")->select("VoterId")->get();
        $voterIdList = array();

        foreach($tickets as $ticket){
            $voterIdList[] = $ticket->VoterId;
        }

        $votes = DB::table("votes")->selectRaw("DISTINCT(VoterId),created_at")->where("VoteF2F", "NO")->whereNotIn("VoterId",$voterIdList)->get();

        $ticketNotCreated = array();

        foreach($votes as $vote){
            $ticketNotCreated[] = [
                "VoterId" => $vote->VoterId,
                "created_at" => $vote->created_at,
                "updated_at" => $vote->created_at
            ];
        }

        $gaitems = DB::table("gaitems")->select("VoterId")->groupBy("VoterId")->havingRaw("COUNT(*) > 1")->get();
        $gaitemsId = array();
        if(!empty($gaitems)){
            foreach($gaitems as $item){
                $gaitemsId[] = DB::table("gaitems")->where("VoterId", $item->VoterId)->first()->Id;
            }

            foreach($gaitemsId as $id){
                DB::table("gaitems")->delete($id);
            }
        }
        if(!empty($ticketNotCreated)){
            DB::table("tickets")->insert($ticketNotCreated);
        }
        
        return $this->userModel->Login($request);
    }

    function SetVoterId(Request $request){
        Session::put('VoterId', $request->id);
        // $email = "";
        // if(!empty($voter->Email)){
        //     $email = $voter->Email;
        // }else{
        //     $member = $this->membersModel->GetMember($voter->MemberId, $voter->Pbno, $voter->Branch);
        //     $email = !empty($member) ? $member->email : "";
        //     if(!empty($email)){ 
        //         $this->votersModel->find($request->id)->update([
        //             "Email" => $email
        //         ]);
        //     } 
        // }

        // if(!empty($email)){
        //     $result["status"] = "success";
        //     $result["email"] = $email;
        //     Session::put('VoterId', $request->id);
        //     $this->votersModel->SendOTP($voter, 1);
        // }else{
        //     $result["status"] = "failed";
        // }
        // return $result;
        
    }

    function ResendOtp(Request $request){
        return $this->votersModel->SendOTP(null, 2, true, $request->voterId);
    }

    function VoterLogin(Request $request){
        $validation = array();
        $validation["settingStatus"] = $this->helper->CheckSettingStatus();
        $validation["memberData"] = $this->votersModel->GetMember($request->VoterId);
        $validation["voteData"] = $this->votesModel->CheckVote($request->VoterId);
        return $this->userModel->VoterLogin($request->all(), $validation, $request->ip());
    }

    function ElectionAuthentication(Request $request){
        return $this->userModel->ElectionAuthentication($request->password);
    }

    function ElectionLive(){
        $data = array();
        $data["TitlePage"] = "NOVADECI | Election Live";
        $data["result"] = $this->votesModel->GetElectionLiveResults();
        return view('Components.Guest.ElectionLive', $data);
    }

    function DashboardLive(){
        return redirect()->route('election.live');
    }
}
