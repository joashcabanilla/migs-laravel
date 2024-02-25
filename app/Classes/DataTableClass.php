<?php

namespace App\Classes;

//Model
use App\Models\User;
use App\Models\UsertypeModel;
use App\Models\VotersModel;
use App\Models\VerificationModel;

class DataTableClass
{
    protected $data, $userModel, $userTypeModel, $voterModel, $verificationModel;
    function __construct()
    {
        $this->userModel = new User();
        $this->userTypeModel = new UsertypeModel();  
        $this->voterModel = new VotersModel();
        $this->verificationModel = new VerificationModel();
        $this->data = array();
    }

    function processTable($param){
        $final_query = $param['sql'];
        $columns = $param['columns'];
        $result['iTotalRecords'] = 0;
        $param['union'] = !empty($param['union']) ? $param['union'] : array() ;
        $counter = 0;
   
        if(isset($param['group'])&&$param['group']):
            $result["iTotalRecords"] = count($param['sql']->groupBy($param['group'])->distinct($param['group'])->get());
        elseif(isset($param['having'])&&$param['having']):
            $result["iTotalRecords"] = count($param['sql']->having($param['having'][0][0],$param['having'][0][1],$param['having'][0][2])->get());
        elseif(isset($param['distinct'])&&$param['distinct']):
            if(isset($param['union']) && $param['union']):
                if(count($param['union'])>0):
                    foreach($param['union'] as $unions):
                        $counter++;
   
                        $result["iTotalRecords"] += $unions->distinct($param['distinct'])->count();
                        if($counter!=1):
                            $final_query = $final_query->unionAll($unions);
                        endif;
                    endforeach;
                endif;
            else:
                $result["iTotalRecords"] = $param['sql']->distinct($param['distinct'])->count();
            endif;
   
        else:
            $result["iTotalRecords"] = $param['sql']->count();
        endif;
        if( $param['var']->length > 0 ){
            $final_query = $final_query->skip(intval($param['var']->start))->take(intval($param['var']->length));
        }
   
        $result["iTotalDisplayRecords"] = $result["iTotalRecords"];
   
        if(isset($param['group'])&&$param['group']):
            $tmpgroup = is_array($param['group'])?$param['group']:[$param['group']];
            $final_query = call_user_func_array([$final_query,'groupBy'],$tmpgroup);
        endif; 
        if(isset($param['having'])&&$param['having']):
            foreach ($param['having'] as $con):
                $final_query = call_user_func_array([$final_query,'having'],$con);
            endforeach;
        endif;
        if(isset($param['distinct'])&&$param['distinct']) $final_query->distinct();
   
   
        $result["aaData"] = array();
        $count = intval($param['var']->start?$param['var']->start:0);
        
        foreach ($final_query->get() as $finres){
            $count ++;
            $isAModel = is_a($finres,'Illuminate\Database\Eloquent\Model');
            $mrow = $isAModel ? $finres : (array) $finres;
   
            $tmpr = array();
            foreach ($columns as $cc=>$cval) {
                $val = $mrow[ $cval['db'] ];
   
                if(isset($cval['sortnum'])&&$cval['sortnum']){
                    $tmpr[] = $count;
                }else if ( isset( $cval['formatter'] ) ) {
                    $tmpr[] = $cval['formatter']( $val, $mrow);
                }else {
                    $tmpr[] = $val;
                }
            }
            $result["aaData"][] = $tmpr;
        }
   
        echo json_encode($result);
    }

    function userTable($data){
        $var = (object) $data;
        $userTypeList = $this->userTypeModel->getUserTypeArray();

        $query = $this->userModel->userTable($var);
        
        $columns =[
            ['db' => 'Id', 'dt' => 0,'orderable' => false, 'sortnum'=>true],

            ['db' => 'UserType', 'dt' => 1,'formatter' => function($d) use($userTypeList){
                return ucwords(strtolower($userTypeList[$d]));
            }],

            ['db' => 'Name', 'dt' => 2, 'formatter' => function($d){
                return $d;
            }],

            ['db' => 'Branch', 'dt' => 3, 'formatter' => function($d){
                return strtoupper($d);
            }],

            ['db' => 'LastLogin', 'dt' => 4,'formatter' => function($d){
                return !empty($d) ? date("m/d/Y h:i A", strtotime($d)) : "";
            }],

            ['db' => 'LastIp', 'dt' => 5],

            ['db' => 'Id', 'dt' => 6, 'formatter' => function($d,$mrow){
                if($mrow->UserType != 5){
                    return "<button type='submit' class='btn btn-sm btn-primary elevation-1 editBtn' data-id='".$d."'><i class='fas fa-edit' aria-hidden='true'></i></button>";
                }
            }]
        ];

        $params = array(
            "var" => $var,
            "columns" => $columns,
            "sql" => $query  
        );
        
        return $this->processTable($params);
    }

    function memberTable($data){
        $var = (object) $data;
        $query = $this->voterModel->memberTable($var);
        
        $columns =[
            ['db' => 'Id', 'dt' => 0, 'formatter' => function($d){
                return $d;
            }],

            ['db' => 'Pbno', 'dt' => 1],

            ['db' => 'MemberId', 'dt' => 2],

            ['db' => 'Name', 'dt' => 3],

            ['db' => 'Branch', 'dt' => 4],

            ['db' => 'Birthdate', 'dt' => 5,'formatter' => function($d){
                return !empty($d) ? date("m/d/Y", strtotime($d)) : "";
            }],

            ['db' => 'Status', 'dt' => 6,'formatter' => function($d){
               $status = $d != "MIGS" ? "NON-MIGS" : $d;
               $color = $d != "MIGS" ? "border border-danger text-danger" : "border border-success text-success";
               return "<p class='text-center font-weight-bold m-0 p-1 rounded-lg elevation-1 ".$color."'>".$status."</p>";
            }],

            ['db' => 'Id', 'dt' => 7, 'formatter' => function($d){
                return "<button type='submit' class='btn btn-sm btn-primary elevation-1 editBtn' data-id='".$d."'><i class='fas fa-edit' aria-hidden='true'></i></button>";
            }]
        ];

        $params = array(
            "var" => $var,
            "columns" => $columns,
            "sql" => $query  
        );
        
        return $this->processTable($params);
    }

    function memberStatusTable($data){
        $var = (object) $data;
        $query = $this->voterModel->memberTable($var);
        
        $columns =[
            ['db' => 'Id', 'dt' => 0, 'formatter' => function($d){
                return $d;
            }],

            ['db' => 'Pbno', 'dt' => 1],

            ['db' => 'MemberId', 'dt' => 2],

            ['db' => 'Name', 'dt' => 3],

            ['db' => 'Branch', 'dt' => 4],

            ['db' => 'Status', 'dt' => 5,'formatter' => function($d){
               $status = $d != "MIGS" ? "NON-MIGS" : $d;
               $color = $d != "MIGS" ? "border border-danger text-danger" : "border border-success text-success";
               return "<p class='text-center font-weight-bold m-0 p-1 rounded-lg elevation-1 ".$color."'>".$status."</p>";
            }],

            ['db' => 'Id', 'dt' => 6, 'formatter' => function($d){
                return "<button type='submit' class='btn btn-sm btn-primary elevation-1 editBtn' data-id='".$d."'><i class='fas fa-edit' aria-hidden='true'></i></button>";
            }]
        ];

        $params = array(
            "var" => $var,
            "columns" => $columns,
            "sql" => $query  
        );
        
        return $this->processTable($params);
    }

    function verificationTable($data){
        $memberList = array();
        $userList = array();
        $verifiedList = array();

        $var = (object) $data;
        $query = $this->verificationModel->verificationTable($var);
        $forVerification = $query->get();

        if(!empty($forVerification)){
            $idList = array();
            foreach($forVerification as $vMember){
                $idList[] = $vMember->VoterId;
            }

            $memberList = $this->voterModel->GetMemberForVerification($var, $idList);

            if(!empty($memberList)){
                $query = $query->whereIn("VoterId", array_keys($memberList)); 
            }else{
                $query = $query->where("Id", 0);
            }
        }

        $query = $query->orderBy("Id", "ASC");

        $userList = $this->userModel->GetUserListNotMember();
        if(!empty($userList)){
            foreach($userList as $user){
                $verifiedList[$user->Id] = $user->FirstName . " " . $user->LastName;
            }
        }
        $columns =[
            ['db' => 'Id', 'dt' => 0, 'formatter' => function($d){
                return $d;
            }],

            ['db' => 'VoterId', 'dt' => 1, 'formatter' => function($d) use($memberList) {
                return !empty($memberList) ? $memberList[$d]["Pbno"] : "";
            }],

            ['db' => 'VoterId', 'dt' => 2, 'formatter' => function($d) use($memberList) {
                return !empty($memberList) ? $memberList[$d]["MemberId"] : "";
            }],

            ['db' => 'VoterId', 'dt' => 3, 'formatter' => function($d) use($memberList) {
                return !empty($memberList) ? $memberList[$d]["Name"] : "";
            }],

            ['db' => 'VoterId', 'dt' => 4, 'formatter' => function($d) use($memberList) {
                return !empty($memberList) ? $memberList[$d]["Branch"] : "";
            }],

            ['db' => 'VoterId', 'dt' => 5, 'formatter' => function($d) use($memberList) {
                return !empty($memberList) ? $memberList[$d]["Contact"] : "";
            }],

            ['db' => 'Status', 'dt' => 6,'formatter' => function($d){
               $color = $d != "Verified" ? "border border-danger text-danger" : "border border-success text-success";
               return "<p class='text-center font-weight-bold m-0 p-1 rounded-lg elevation-1 ".$color."'>".strtoupper($d)."</p>";
            }],

            ['db' => 'VerifiedBy', 'dt' => 7,'formatter' => function($d) use($verifiedList){
                return !empty($verifiedList) && isset($verifiedList[$d]) ? $verifiedList[$d] : "";
            }],

            ['db' => 'DateTime', 'dt' => 7,'formatter' => function($d){
                return !empty($d) ? date("m/d/Y h:i A", strtotime($d)) : "";
            }],

            ['db' => 'Id', 'dt' => 9, 'formatter' => function($d,$row) use($memberList){
                $id = $row->Id;
                $voterId = $row->VoterId;
                $pbno = !empty($memberList) ? $memberList[$voterId]["Pbno"] : "";
                $memberId = !empty($memberList) ? $memberList[$voterId]["MemberId"] : "";
                $name = !empty($memberList) ? $memberList[$voterId]["Name"] : "";
                return "<button type='submit' class='btn btn-sm btn-primary elevation-1 editBtn' data-id='".$id."' data-pbno='".$pbno."' data-memberid='".$memberId."' data-name='".$name."' data-status='".$row->Status."'><i class='fas fa-edit' aria-hidden='true'></i></button>";
            }]
        ];

        $params = array(
            "var" => $var,
            "columns" => $columns,
            "sql" => $query  
        );
        
        return $this->processTable($params);
    }
}
