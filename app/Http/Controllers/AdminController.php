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
use App\Models\CandidateModel;
use App\Models\VotesModel;
use App\Models\GaItemsModel;

//Class
use App\Classes\HelperClass;
use App\Classes\DataTableClass;

class AdminController extends Controller
{
    protected $data, $helper, $datatable, $votersModel, $usertypeModel, $userModel, $verificationModel, $positionModel, $candidateModel, $votesModel, $gaItemsModel;

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
        $this->candidateModel = new CandidateModel();
        $this->votesModel = new VotesModel();
        $this->gaItemsModel = new GaItemsModel();
        $this->data = array();
    }

    //GET Method
    function AdminPage(){
        switch(Auth::user()->UserType){
            case 1:
                $this->data["TitlePage"] = "NOVADECI ADMIN";
            break;
            case 2:
                $this->data["TitlePage"] = "NOVADECI ELECTION";
            break;
            case 3:
                $this->data["TitlePage"] = "NOVADECI UTILITY";
            break;
            case 4:
                $this->data["TitlePage"] = "NOVADECI SUPPLIES";
            break;
            case 6:
                $this->data["TitlePage"] = "NOVADECI UTILITY AND SUPPLIES";
            break;
        }
        $this->data['UserTypeList'] = $this->usertypeModel->getUserTypeArray();
        return view('Layouts.Admin',$this->data);
    }

    function Maintenance(){
        $tableArray = $this->helper->getAllDatabaseTable();
        $tableList = array();
        foreach($tableArray as $table){
            foreach($table as $tablename){
                $tableList[] = trim($tablename);
            }
        }
        $this->data["tables"] = $tableList;
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
    function ElectionDashboard(){
        $this->data["positionList"] = $this->positionModel->GetPositionList();
        return view('Components.Admin.ElectionDashboard', $this->data);
    }

    function ElectionPosition(){
        return view('Components.Admin.ElectionPositions', $this->data);
    }

    function ElectionCandidate(){
        $this->data['position'] = $this->positionModel->GetPositionList();
        return view('Components.Admin.ElectionCandidates', $this->data);
    }
    
    function ElectionTickets(){
        $this->data['branch'] = $this->votersModel->GetBranchList();
        return view('Components.Admin.ElectionTickets', $this->data);
    }

    function ElectionSummary(){
        $this->data['candidates'] = $this->candidateModel->GetAllCandidate();
        $this->data['positions'] = $this->positionModel->GetPositionList();
        return view('Components.Admin.ElectionSummary', $this->data);
    }

    //for Supplies
    function Supplies(){
        $this->data['branch'] = $this->votersModel->GetBranchList();
        $this->data['counter'] = $this->gaItemsModel->getCounter(Auth::user()->Id);
        return view('Components.Admin.Supplies', $this->data);
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
    
    function GetElectionDashboardData(){
        $migs = $this->votersModel->GetTotalMember("MIGS");
        $votedVotersList = $this->votesModel->GetAllVotersVoted();
        $voted = count($votedVotersList);
        $quorum = ($voted / $migs) * 100;
        
        $branchList = $this->votersModel->GetBranchList();
        $positionList = $this->positionModel->GetPositionList();
        $candidateList = $this->candidateModel->GetAllCandidate();

        $branchArray = $positionArray = $candidateArray = $votePerBranchList = $memberList = array();
        $voteCountPerBranch = $positionVoteCountPerBranch = array();

        foreach($branchList as $branch){
            $branchArray[] = $branch->Branch;
        }

        foreach($positionList as $position){
            $positionArray[$position->Id] = strtoupper(str_replace(' ','',$position->Description));
        }

        foreach($candidateList as $candidate){
            $candidateArray[$candidate["Position"]][$candidate["Id"]] = strtoupper(str_replace('ñ', 'Ñ',$candidate['FirstName']." ".$candidate["MiddleName"]." ".$candidate["LastName"]));
        }

        $voterList = array();
        if(!empty($votedVotersList)){
            foreach($votedVotersList as $voter){
                $voterList[] = $voter->VoterId;
            }
            $memberList = $this->votersModel->GetMemberIDs($voterList);

            foreach($memberList as $member){
                $votePerBranchList[$member->Branch][] = $member->Id;
            }

            foreach($branchArray as $branch){
                $voteCountPerBranch[] = isset($votePerBranchList[$branch]) ? count($votePerBranchList[$branch]) : 0;
            }

            $votePerCandidate = array();
            $voteListCandidateArray = $this->votesModel->GetAllVotePerCandidate();
            foreach( $voteListCandidateArray as $vote){
                $votePerCandidate[$vote->Candidate][] = $vote->Id;
            }
            
            foreach($candidateArray as $positionId => $positions){
                foreach($positions as $candidateId => $candidate){
                    $positionVoteCountPerBranch[$positionArray[$positionId]]["labels"][] = $candidate;
                    $positionVoteCountPerBranch[$positionArray[$positionId]]["data"][] = isset($votePerCandidate[$candidateId]) ? count($votePerCandidate[$candidateId]) : 0;
                }
            }

        }else{
            foreach($branchArray as $branch){
                $voteCountPerBranch[] = 0;
            }

            foreach($candidateArray as $positionId => $positions){
                foreach($positions as $candidateId => $candidate){
                    $positionVoteCountPerBranch[$positionArray[$positionId]]["labels"][] = $candidate;
                    $positionVoteCountPerBranch[$positionArray[$positionId]]["data"][] = 0;
                }
            }
        }

        $result = [
            "total" => [
                "totalMembers" => number_format($this->votersModel->GetTotalMember()),
                "totalMigs" => number_format($migs),
                "totalVoted" => number_format($voted),
                "totalNonVoting" => number_format(count($this->votesModel->GetAllVotersVoted(true))),
                "totalQuorum" => number_format($quorum,2),
                "totalPositions" => number_format(count($positionList)),
                "totalCandidates" => number_format(count($candidateList)),
            ],
            "voteTally" => [
                "branch" => [
                    "labels" =>  $branchArray,
                    "data" => $voteCountPerBranch
                ],
                "positions" => $positionVoteCountPerBranch,
            ],
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

    function ElectionCandidateDataTable(Request $request){
        return $this->datatable->candidateTable($request->all());
    }

    function AddUpdateElectionCandidate(Request $request){
        return $this->candidateModel->AddUpdateCandidate($request);
    }

    function GetElectionCandidate(Request $request){
        return $this->candidateModel->GetCandidate($request->id);
    }

    function ElectionTicketDataTable(Request $request){
        return $this->datatable->ticketTable($request->all());
    }

    function SuppliesDataTable(Request $request){
        return $this->datatable->suppliesTable($request->all());
    }

    function GetMemberGaItems(Request $request){
        $memberData = $this->votersModel->GetMember($request->id);
        $voteData = $this->votesModel->GetVote($request->id);
        $voteF2F = strtoupper($voteData[0]->VoteF2F);
        $member = [
            "VoterId" => $memberData->Id,
            "Pbno" => $memberData->Pbno,
            "MemberId" => $memberData->MemberId,
            "Name" => $memberData->FirstName." ".$memberData->MiddleName." ".$memberData->LastName,
            "Branch" => $memberData->Branch,
            "VoteF2F" => $voteF2F,
            "RegisterVoteMethod" => $voteF2F == "NO" ? "ONLINE" : "FACE TO FACE"
        ];
        
        return $member;
    }

    function ReceivedGaItems(Request $request){
        $this->gaItemsModel->RegisterMember($request->all());
        return $this->gaItemsModel->getCounter(Auth::user()->Id);
    }
}
