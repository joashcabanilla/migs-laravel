<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


//Model
use App\Models\VotersModel;
use App\Models\UsertypeModel;
use App\Models\User;
use App\Models\VerificationModel;
use App\Models\PositionsModel;

//Class
use App\Classes\HelperClass;
use App\Classes\DataTableClass;

class AdminController extends Controller
{
    protected $data, $helper, $datatable, $votersModel, $usertypeModel, $userModel, $verificationModel, $positionModel;

    public function __construct()
    {
        $this->middleware('admin');
        $this->votersModel = new VotersModel();
        $this->usertypeModel = new UsertypeModel();
        $this->helper = new HelperClass();
        $this->datatable = new DataTableClass();
        $this->userModel = new User();
        $this->verificationModel = new VerificationModel();
        $this->positionModel = new PositionsModel();
        $this->data = array();
    }

    //GET Method
    function AdminPage(){
        switch(Auth::user()->UserType){
            case 1:
                $this->data["TitlePage"] = "NOVADECI ADMIN";
            break;
            case 3:
                $this->data["TitlePage"] = "NOVADECI UTILITY";
            break;
        }
        $this->data['UserTypeList'] = $this->usertypeModel->getUserTypeArray();
        return view('Layouts.Admin',$this->data);
    }

    function Maintenance(){
        $this->data["tables"] = $this->helper->getAllDatabaseTable();
        return view('Components.Admin.Maintenance',$this->data);
    }

    function User(){
        $this->data['usertype'] = $this->usertypeModel->getUserType();
        $this->data['branch'] = $this->votersModel->GetBranchList();
        return view('Components.Admin.User', $this->data);
    }

    //for Utility
    function UtilityDashboard(){
        $this->data = [
            "totalMembers" => number_format($this->votersModel->GetTotalMember()),
            "updatedBirthdate" => number_format($this->votersModel->GetTotalUpdateBirthDate()),
            "updateStatus" => number_format($this->votersModel->GetTotalUpdateStatus()),
            "forVerification" => number_format($this->verificationModel->GetTotalVerification("Pending")),
            "verifiedStatus" => number_format($this->verificationModel->GetTotalVerification("Verified"))
        ];
        return view('Components.Admin.UtilityDashboard', $this->data);
    }

    function UtilityMemberInfo(){
        $this->data['branch'] = $this->votersModel->GetBranchList();
        $this->data['status'] = $this->votersModel->GetStatusList();
        return view('Components.Admin.UtilityMember', $this->data);
    }

    function UtilityStatus(){
        $this->data['branch'] = $this->votersModel->GetBranchList();
        $this->data['status'] = $this->votersModel->GetStatusList();
        return view('Components.Admin.UtilityStatus', $this->data);
    }

    function UtilityVerification(){
        $this->data['branch'] = $this->votersModel->GetBranchList();
        $this->data['verificationStatus'] = ["Pending","Verified"];
        return view('Components.Admin.UtilityVerification', $this->data);
    }

    //for Election
    function ElectionPosition(){
        return view('Components.Admin.ElectionPositions', $this->data);
    }

    function ElectionCandidate(){
        return view('Components.Admin.ElectionCandidates', $this->data);
    }

    //Post Method
    function PostLogout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response('logout',200); 
    }

    function BatchInsertData(Request $request){
        return $this->helper->BatchInsertData($request->table, $request->insert);
    }

    function UserDataTable(Request $request){
        return $this->datatable->userTable($request->all());
    }

    function CreateUpdateUser(Request $request){
        return $this->userModel->CreateUpdateUser($request->all());
    }

    function GetUser(Request $request){
        return $this->userModel->GetUser($request->id);
    }

    function GetUtilityDashboardData(){
        $result = [
            "totalMembers" => number_format($this->votersModel->GetTotalMember()),
            "updatedBirthdate" => number_format($this->votersModel->GetTotalUpdateBirthDate()),
            "updateStatus" => number_format($this->votersModel->GetTotalUpdateStatus()),
            "forVerification" => number_format($this->verificationModel->GetTotalVerification("Pending")),
            "verifiedStatus" => number_format($this->verificationModel->GetTotalVerification("Verified"))
        ];
        
        return $result;
    }

    function MemberDataTable(Request $request){
        return $this->datatable->memberTable($request->all());
    }

    function AddMember(Request $request){
        return $this->votersModel->AddMember($request->all());
    }

    function GetMember(Request $request){
        return $this->votersModel->GetMember($request->id);
    }

    function UpdateMember(Request $request){
        return $this->votersModel->UpdateMember($request->all());
    }

    function MemberStatusDataTable(Request $request){ 
        return $this->datatable->memberStatusTable($request->all());
    }

    function UpdateMemberStatus(Request $request){
        $verified = $this->verificationModel->CheckMemberVerified($request->Id);
        return $this->votersModel->UpdateMemberStatus($request->all(), $verified);
    }

    function VerificationDataTable(Request $request){
        return $this->datatable->verificationTable($request->all());
    }
    
    function AddMemberVerification(Request $request){
        return $this->verificationModel->AddMember($request->all());
    }

    function UpdateMemberVerification(Request $request){
        return $this->verificationModel->UpdateMember($request->all());
    }

    function ElectionPositionDataTable(Request $request){
        return $this->datatable->positionTable($request->all());
    }

    function AddUpdateElectionPosition(Request $request){
        return $this->positionModel->AddUpdatePosition($request->all());
    }

    function GetElectionPosition(Request $request){
        return $this->positionModel->GetPosition($request->id);
    }
}
