<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembersModel extends Model
{
    use HasFactory;
    protected $table = 'members';
    protected $fillable = [
        'memid',
        'pbno',
        'firstname',
        'middlename',
        'lastname',
        'birthdate',
        'branch',
        'cpNumber',
        'email',
        'occupation',
        'tinNumber',
    ];

    function GetMember($memid, $pbno, $branch){
        return $this->where("memid", $memid)
                    ->where("pbno", $pbno)
                    ->where("branch", $branch)
                    ->first();
    }
}
