<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Model
use App\Models\VotersModel;
use App\Models\User;
use App\Models\VerificationModel;

//Class
use App\Classes\HelperClass;

class GuestController extends Controller
{
    protected $data, $helper, $votersModel, $userModel, $verificationModel;

    public function __construct()
    {
        $this->middleware('guest');
        $this->votersModel = new VotersModel();
        $this->userModel = new User();
        $this->helper = new HelperClass();
        $this->verificationModel = new VerificationModel();
        $this->data = array();
    }

    //GET Method
    function Login(){
        $this->data["TitlePage"] = "NOVADECI Login";
        return view('Components.Guest.LoginAdmin',$this->data);
    }

    function GetVerifier(){
        $this->data["branchContact"] = $this->helper->BranchContactList();
        $this->data["TitlePage"] = "NOVADECI MIGS Verifier";
        return view('Components.Guest.Verifier',$this->data);
    }

    //Post Method
    function VerifyMember(Request $request){
        $searched = $this->votersModel->SearchMember($request->search);
        $result["status"] = "success";
        $result["electionStatus"] = $this->helper->CheckElectionStatus();
        
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
}
