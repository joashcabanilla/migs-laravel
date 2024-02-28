<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
       'UserType',
       'FirstName',
       'MiddleName',
       'LastName',
       'Branch',
       'username',
       'password',
       'LastLogin',
       'LastIp',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    function CreateUpdateUser($data){
        $result = array();
        $defaultpassword = "nvdc1976";
        $result["status"] = "success";
        $var = (object) $data;
        $id = 0;

        if(isset($var->id) && !empty($var->id)){
            $id = $var->id;
            $rules = [
                'username' => ['required', 'string', 'min:5',Rule::unique('users')->ignore($var->id)],
                'firstname' => ['required','string', 'min:2'],
                'lastname' => ['required','string', 'min:2'],           
            ];
        }else{
            $rules = [
                'username' => ['required', 'string', 'min:5','unique:users'],
                'password' => ['string', 'min:5'],
                'firstname' => ['required','string', 'min:2'],
                'lastname' => ['required','string', 'min:2'],
            ];
        }
        
        
        $validator = Validator::make($data,$rules);
        
        if($validator->fails()){
            $result["error"] = $validator->errors();
            $result["status"] = "failed";
        }
        else{
            $password = isset($var->defaultpassword) ? $defaultpassword : $var->password;
            $firstname = strtoupper(str_replace('ñ', 'Ñ', $var->firstname));
            $middlename = strtoupper(str_replace('ñ', 'Ñ', $var->middlename));
            $lastname = strtoupper(str_replace('ñ', 'Ñ', $var->lastname));
            $insertData = [
                "UserType" => $var->userType,
                "FirstName" => $firstname,
                "MiddleName" => $middlename,
                "LastName" => $lastname,
                "Branch" => $var->branch,
                "username" => $var->username,
            ];

            if(!empty($password)){
                $insertData["password"] = Hash::make($password);
            }

            $this->updateOrCreate([
                "Id" => $id
            ],$insertData);
        }

        return $result;
    }

    function Login($data){ 
        $result = array();
        $result["status"] = "success";
        $user = $this->where("username",$data->username)->first();
        
        if(!empty($user)){
            if(Hash::check($data->password,$user->password)){
                Auth::login($user,true);
                $user->update([
                    'LastLogin' => Carbon::now(),
                    'LastIp' => $data->ip()    
                ]);
            }else{
                $result["status"] = "failed";
                $result["message"] = "Incorrect Password";
            }
        }else{
            $result["status"] = "failed";
            $result["message"] = "Incorrect Username";
        }

        return $result;
    }

    function userTable($data){
        $query = $this->select(
            "Id",
            "UserType",
            DB::raw("CONCAT(COALESCE(FirstName, ''), ' ', COALESCE(MiddleName, ''), ' ', COALESCE(LastName, '')) AS Name"),
            "Branch",
            "LastLogin",
            "LastIp"
        );

        if(!empty($data->filterSearch)){
            $search = strtoupper(str_replace('ñ', 'Ñ', $data->filterSearch));
            $query->where(function($q) use($search){
                $q->orWhereRaw("CONCAT(COALESCE(FirstName, ''), ' ', COALESCE(MiddleName, ''), ' ', COALESCE(LastName, '')) LIKE '%".$search."%'");
            });
        }

        $query = !empty($data->filterUserType) ? $query->where("UserType", $data->filterUserType) : $query;
        $query = !empty($data->filterBranch) ? $query->where("Branch", $data->filterBranch) : $query;
        
        return $query;
    } 

    function GetUser($id){
        return $this->find($id);
    }
    
    function GetUserListNotMember(){
        return $this->where("UserType", "!=", "5")->get();
    }

    private function MemberLogin($data,$memberData){
        $result = array();
        $result["status"] = "failed";
        $result["message"] = "Incorrect Birthdate";

        $member = $this->where("username",$data->VoterId."-".$memberData->FirstName)->first();
        
        if(!empty($member)){
            if(Hash::check($data->Birthdate,$member->password)){
                Auth::login($member,true);
                $member->update([
                    'LastLogin' => Carbon::now(),
                    'LastIp' => $data->ip()    
                ]);
                $result["status"] = "success";
                return $result;
            }

        }else{

            if($memberData->Birthdate == $data->Birthdate){
                $user = $this->create([
                    "UserType" => 5,
                    "FirstName" => $memberData->FirstName,
                    "MiddleName" => $memberData->MiddleName,
                    "LastName" => $memberData->LastName,
                    "Branch" => $memberData->Branch,
                    "username" => $data->VoterId."-".$memberData->FirstName,
                    "password" => Hash::make($memberData->Birthdate),
                ]);
                Auth::login($user,true);
                $user->update([
                    'LastLogin' => Carbon::now(),
                    'LastIp' => $data->ip()    
                ]);
                $result["status"] = "success";
                return $result;
            }
        }

        return $result;
    }

    function VoterLogin($data, $validation){
        $result = array();
        $forChecking = (object) $validation;

        if($forChecking->electionStatus == "open"){
            return $this->MemberLogin($data,$forChecking->memberData);
        }

        
        if($forChecking->voteData > 0){
            return $this->MemberLogin($data,$forChecking->memberData);
        }

        if($forChecking->f2fElectionStatus == "open"){
            if($forChecking->memberData->Birthdate != $data->Birthdate){
                $result["status"] = "failed";
                $result["message"] = "Incorrect Birthdate";
                return $result;
            }else{
                if(isset($data->authenticated) && $data->authenticated){
                    return $this->MemberLogin($data,$forChecking->memberData);
                }else{
                    $result["status"] = "not authenticated";
                    $result["message"] = "face-to-face election needs to be authenticated by NOVADECI staff.";
                    return $result; 
                }
            }
        }

        $result["status"] = "election closed";
        return $result;
    }

    function ElectionAuthentication($password){
        $result = array();
        $result["status"] = "failed";
        $result["message"] = "Incorrect Password";
        $admin = $this->whereIn("UserType",[1,2])->get();
        
        if(!empty($admin)){
            foreach($admin as $user){
                if(Hash::check($password,$user->password)){
                    $result["status"] = "success";
                    $result["message"] = "authenticated";
                    return $result;
                }
            }
        }

        return $result;
    }
}
