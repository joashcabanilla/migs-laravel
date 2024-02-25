<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class VotersModel extends Model
{
    use HasFactory;
    protected $table = 'voters';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'Pbno',
        'MemberId',
        'FirstName',
        'MiddleName',
        'LastName',
        'Birthdate',
        'UpdateBirthdateBy',
        'UpdateBirthdate',
        'Contact',
        'MembershipDate',
        'Status',
        'UpdateStatusBy',
        'UpdateStatus',
        'Branch',
    ];

    function SearchMember($id){
        return $this->where("Pbno",$id)->orWhere("MemberId",$id)->get();
    }

    function GetBranchList(){
        return $this->select("Branch")->distinct()->orderBy("Branch", "ASC")->get();
    }

    function GetTotalMember(){
        return $this->count();
    }

    function GetTotalUpdateBirthDate(){
        return $this->where("UpdateBirthDateBy","!=", NULL)->count();
    }

    function GetTotalUpdateStatus(){
        return $this->where("UpdateStatusBy","!=", NULL)->count();
    }

    function GetStatusList(){
        return $this->select("Status")->distinct()->orderBy("Status", "ASC")->get();
    }

    function memberTable($data){
        $query = $this->select(
            "Id",
            "Pbno",
            "MemberId",
            DB::raw("CONCAT(COALESCE(FirstName, ''), ' ', COALESCE(MiddleName, ''), ' ', COALESCE(LastName, '')) AS Name"),
            "Branch",
            "Birthdate",
            "Status"
        );
        
        if(!empty($data->filterSearch)){
            $search = strtoupper(str_replace('ñ', 'Ñ', $data->filterSearch));
            $query->where(function($q) use($search){
                $q->orWhereRaw("CONCAT(COALESCE(FirstName, ''), ' ', COALESCE(MiddleName, ''), ' ', COALESCE(LastName, '')) LIKE '%".$search."%'");
                $q->orWhere("Pbno", $search);
                $q->orWhere("MemberId", $search);
            });
        }

        $query = !empty($data->filterStatus) ? $query->where("Status", $data->filterStatus) : $query;
        $query = !empty($data->filterBranch) ? $query->where("Branch", $data->filterBranch) : $query;
        $query = $query->orderBy("Id", "ASC");
        return $query;
    }

    function AddMember($data){
        return $this->create($data);
    }

    function GetMember($id){
        return $this->find($id);
    }

    function UpdateMember($data){
        $var = (object) $data;
        $member = $this->find($var->Id);
        if($member->Birthdate != $var->Birthdate){
            $member->update([
                "UpdateBirthdateBy" => Auth::user()->Id,
                "UpdateBirthdate" => Carbon::now()
            ]);
        }
        $member->update($data);
    }

    function UpdateMemberStatus($data,$verified){
        $result = array();
        $result["status"] = "success";
        $var = (object) $data;
        $member = $this->find($var->Id);
         
        if($member->Status != "MIGS" && $var->Status == "MIGS"){
            if($verified){
                $member->update([
                    "UpdateStatusBy" => Auth::user()->Id,
                    "UpdateStatus" => Carbon::now()
                ]);
                $data["Status"] = $var->Status;
            }else{
                $result["status"] = "failed";
                $result["message"] = "The member is not verified. Please proceed to 'Utility Verification' to verify the member.";
                $data["Status"] = $member->Status;
            }
        }      

        $member->update($data);
        return $result;
    }

    function updateContact($id, $contact){
        $this->find($id)->update(["Contact" => $contact]);
    }
}
