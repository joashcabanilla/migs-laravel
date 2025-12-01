<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DataController extends Controller
{
    private function isValidDate($date) {
        try {
            Carbon::parse($date);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    function import(Request $request){
        $request->validate([
            "file" => "required|file|mimetypes:csv,txt,application/octet-stream,text/plain"
        ]);

        $file = $request->file("file");
        $csvData = file_get_contents($file->getRealPath());
        $csvData = mb_convert_encoding($csvData, 'UTF-8', 'Windows-1252');
        $parseData = preg_split('/\r\n|\n|\r/', $csvData);
        $totalRecords = 0;

        logger("Starting CSV file parsing.");
        foreach ($parseData as $rowNumber => $data) {
           if($rowNumber > 0){
                $member =  (array) str_getcsv($data);
                try {
                    $insertData[] = [
                        "MemberId" => $member[0],
                        "Pbno" => $member[1],
                        "FirstName" => $member[2],
                        "MiddleName" => $member[3],
                        "LastName" => $member[4],
                        "Branch" => $member[5],
                        "Status" => $member[6],
                        "MembershipDate" => $this->isValidDate($member[7]) ? date("Y-m-d", strtotime($member[7])) : Carbon::now()->format('Y-m-d'),
                        "created_at" => Carbon::now()
                    ];
                    $totalRecords++;
                } catch (\Exception $e) {
                    logger("Skipping invalid row #{$rowNumber}: " . json_encode($member));
                    continue;
                }
               
           } 
        }

        logger("CSV file parsing completed.");
        logger("Inserting data into the database.");
        $data = collect($insertData);
        $data->chunk(1000)->each(function ($chunk) use($request) {
            DB::table($request->tablename)->insert($chunk->toArray());
            logger("Inserted " . count($chunk->toArray()) . " data.");
        });
        logger("All data inserted successfully.");

        $result = [
            "success" => true,
            "totalRecords" => $totalRecords,
            "message" => "All data inserted successfully."
        ];

        return response()->json($result, 200);
    }
}