<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class GaItemsModel extends Model
{
    use HasFactory;
    protected $table = 'gaitems';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'VoterId',
        'Pbno',
        'MemberId',
        'RegisterBy',
        'Register'
    ];

    function getCounter($registerBy){
        $currentDateTime = Carbon::now();
        $day = $currentDateTime->format('Y-m-d');
        return number_format($this->where("RegisterBy", $registerBy)->where("Register", $day)->count());
    }

    function getMemberReceivedItems(){
        return $this->get();
    }

    function RegisterMember($data){
        $var = (object) $data;
        $currentDateTime = Carbon::now();
        $day = $currentDateTime->format('Y-m-d');
        $member = [
            "VoterId" => $var->VoterId,
            "Pbno" => $var->Pbno,
            "MemberId" => $var->MemberId,
            "RegisterBy" => Auth::user()->Id,
            "Register" => $day,
        ];

        return $this->create($member);
    }
}
