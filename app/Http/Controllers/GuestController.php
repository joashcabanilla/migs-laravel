<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

//Model
use App\Models\VotersModel;
use App\Models\User;
use App\Models\VerificationModel;
use App\Models\VotesModel;
use App\Models\SettingsModel;

//Class
use App\Classes\HelperClass;

class GuestController extends Controller
{
    protected $data, $helper, $votersModel, $userModel, $verificationModel, $votesModel, $settingModel;

    public function __construct()
    {
        $this->middleware('guest');
        $this->votersModel = new VotersModel();
        $this->userModel = new User();
        $this->helper = new HelperClass();
        $this->verificationModel = new VerificationModel();
        $this->votesModel = new VotesModel();
        $this->settingModel = new SettingsModel();
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
        $setting = $this->settingModel->find(1);
        $this->data["electionStatus"] = $this->helper->CheckElectionStatus();
        $this->data["f2felectionStatus"] = $this->helper->f2fElectionStatus();
        
        if($setting->ElectionStatus == "CLOSED"){
            $this->data["TitlePage"] = "NOVADECI";
            return view('Components.Guest.ElectionClosed',$this->data);
        }

        if(strtoupper(config('app.F2F_ELECTION')) == "NO"){
            if($this->data["electionStatus"] != "open"){
                return view('Components.Guest.ElectionClosed',$this->data);
            }
        }

        $this->data["branchContact"] = $this->helper->BranchContactList();
        $this->data["TitlePage"] = "NOVADECI MIGS Verifier";
        return view('Components.Guest.Verifier',$this->data);
    }

    function Voter(){
        if(Session::has('VoterId')){
            $this->data["TitlePage"] = "NOVADECI Election";
            $this->data["VoterId"] = Session::get('VoterId');
            $member = $this->votersModel->GetMember($this->data["VoterId"]);
            $this->data["Pbno"] = !empty($member->Pbno) ? $member->Pbno : $member->MemberId;
            return view('Components.Guest.VoterLogin',$this->data);
        }else{
            return redirect('/');
        }
    }

    function ElectionClosed(){
        $this->data["TitlePage"] = "NOVADECI Election";
        return view('Components.Guest.ElectionClosed',$this->data);
    }

    //Post Method
    function VerifyMember(Request $request){
        $searched = $this->votersModel->SearchMember($request->search);
        $result["status"] = "success";
        $result["electionStatus"] = $this->helper->CheckElectionStatus();
        $result["f2felectionStatus"] = $this->helper->f2fElectionStatus();
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
        return $this->userModel->Login($request);
    }

    function SetVoterId(Request $request){
        Session::put('VoterId', $request->id);
    }

    function VoterLogin(Request $request){
        $validation = array();
        $validation["electionStatus"] = $this->helper->CheckElectionStatus();
        $validation["f2fElectionStatus"] = $this->helper->f2fElectionStatus();
        $validation["memberData"] = $this->votersModel->GetMember($request->VoterId);
        $validation["voteData"] = $this->votesModel->CheckVote($request->VoterId);
        return $this->userModel->VoterLogin($request, $validation);
    }

    function ElectionAuthentication(Request $request){
        return $this->userModel->ElectionAuthentication($request->password);
    }
}
