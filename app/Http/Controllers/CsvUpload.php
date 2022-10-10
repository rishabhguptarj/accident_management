<?php

namespace App\Http\Controllers;

use App\Imports\csvImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CsvModel;

use Maatwebsite\Excel\Facades\Excel;

class CsvUpload extends Controller
{
    



  public function uploadUsers(Request $request)
  {
      Excel::import(new csvImport, request()->file('csvfile'));
      return response()->json([
        "success" => true,
        "message" => "File successfully uploaded",
        
      ],200);
      
  }


  






    public function uploadCsv(Request $request)
    {
      dd('CSV',$request->all());
        $validator = Validator::make($request->all(),[ 
            'csvfile' => 'required|max:2048',
      ]);   

      if($validator->fails()) {          
          
          return response()->json(['error'=>$validator->errors()], 200);                        
       }
       if ($file = $request->file('csvfile')) {
        $destinationPath = "uploads";
        $file->move($destinationPath,$file->getClientOriginalName());
        $path = $destinationPath."/".$file->getClientOriginalName();
        $fileName = fopen($path,"r");
        $data = array();
        $index = 0;
        while(!feof($fileName)) {
            $filedata = fgetcsv($fileName);
            if($index!==0)
           {
            if(!empty($filedata)){
                 $status = isset($filedata[10]) && $filedata[10] == 'Yes'?1:0;   
                $data[] = array('country'=>$filedata[1],'state'=>$filedata[2],'city'=>$filedata[3],
               'pincode'=>$filedata[4],'fatalities'=>$filedata[6],'age'=>$filedata[7],
               'gender'=>$filedata[8],'vehicle'=>$filedata[9],'insured_status'=>$status,
               'created_at'=>$filedata[5]); 
             }
           }
           $index++;
            
        }
          fclose($fileName);
          CsvModel::insert($data);  
        return response()->json([
            "success" => true,
            "message" => "File successfully uploaded",
            
        ],200);

    }
 }

 public function filter()
 {
    

 }


}
