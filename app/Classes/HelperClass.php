<?php

namespace App\Classes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\SettingsModel;


class HelperClass
{
    function BranchContactList(){
        return [
            // "0933-8673-769 / 0917-8766-796 (Tsora Office)",
            "0917-8766-796 (Tsora Office)",
            "0917-6219-412 / (2)7115041 (Bulacan Office)",
            "0917-6233-640 / 0917-8766-794 (Fairview Office)",
            "0917-8350-689 / 0933-8673-779 (Kiko Office)",
            "0917-8766-792 / 896-204-26 (Camarin Office)",
            "0917-8766-797 / 0933-8673-768 (Cubao Office)",
            "0917-6312-915 / 0933-8673-777 (BSilang Office)",
            "0917-8766-802 (Lagro Office)",
            "0917-620-3141 (Main Office)",
            "0917-620-2749 (Main Office)",
            "0917-620-2618 (Main Office)",
            "0917-876-6795 (Main Office)"
        ];
    }

    function CheckSettingStatus(){
        $setting = SettingsModel::find(1);
        $result = [
            "verifier" => $setting->VerifierStatus,
            "election" => $setting->ElectionStatus,
            "gaDate" => $setting->GADate
        ];
        return $result;
    }

    function getAllDatabaseTable(){
        $tables = DB::select('SHOW TABLES');
        return $tables;
    }

    function BatchInsertData($table, $data){
        $result = array();
        
        if(!empty($data)){
            foreach($data as $rowData){
                foreach($rowData as $key => $row){
                 $dbData[trim($key)] = !empty($row) ? utf8_encode(utf8_decode(trim($row))) : NULL;
                }
                $insertData[] = $dbData;
            }
            $dbInsert = DB::table(trim($table))->insert($insertData);
            if($dbInsert){
                $result["status"] = "success";
            }else{
                $result["status"] = "failed";
                $result["error"] = $insertData;
            }
        }else{
            $result["status"] = "failed";
            $result["error"] = $data;
        }

        return $result;
    }
}
