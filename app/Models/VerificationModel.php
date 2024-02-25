<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class VerificationModel extends Model
{
    use HasFactory;
    protected $table = 'verification';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
       'VoterId',
       'Status',
       'DateTime'
    ];

    function GetTotalVerification($status){
        return $this->where("Status", $status)->count();
    }

    function CheckMemberVerified($id){
        $result = false; 
        $member = $this->find($id);
        if(!empty($member) && $member->Status == "Verified"){
            $result = true;
        }
        return $result;
    }

    function AddMember($data){
        $var = (object) $data;
        $result = array();
        $result["status"] = "success";
        $result["message"] = "Your request for MIGS status verification has been successfully sent.";

        $member = $this->where("VoterId",$var->Id)->first();
        if(!empty($member)){
            $result["status"] = "failed";
            $result["message"] = "You already have a request for MIGS status verification. Please wait for your account to be verified. Thank you for your understanding.";
        }else{
            $this->create([
                "VoterId" => $var->Id,
                "DateTime" => Carbon::now()
            ]);
        }
        return $result;
    }

    function GetVerificationList($data = array()){
        $var = (object) $data;
        $result = $this;
        if(!empty($var->filterStatus)){
            $result = $result->where("Status", $var->filterStatus);
        }
        return $result->get();
    }
}
