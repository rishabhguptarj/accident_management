<?php

namespace App\Http\Controllers;

use App\Imports\csvImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CsvModel;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;

class CsvUpload extends Controller
{

      public function uploadCsv(Request $request)
    {
      // dd('CSV',$request->all());
        $validator = Validator::make($request->all(),[ 
            'csvfile' => 'required|max:2048',
      ]);   

      if($validator->fails()) {          
          
          return response()->json(['error'=>$validator->errors()], 200);                        
       }
       if ($file = $request->file('csvfile')) {
        $destinationPath = "uploads/CSV/";
        $file->move($destinationPath,time()."_".$file->getClientOriginalName());
          return response()->json([
          "success" => true,
          "message" => "File successfully uploaded",
          ],200);
    }
 }
 public function csvCron(){
  $path = public_path('uploads/CSV');
  $files = \File::files($path);
  if(empty($files)){
    return response()->json([
      "success" => true,
      "message" => "No files To upload",

      ],200);
  }
  $data = array();
 foreach($files as $f=>$v){
  $index = 0;
  $data = array();
  $fileName = fopen($v,"r");
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
  CsvModel::insert($data);  
  fclose($fileName);
  $fileNameString = explode("\\", $v);
  $fileNameString = $fileNameString[count($fileNameString)-1];

  \File::copy($path."/".$fileNameString,public_path('uploads/uploadedCSV/'.$fileNameString));
  unlink($path."/".$fileNameString);
 }
    return response()->json([
      "success" => true,
      "message" => "File successfully uploaded",

      ],200);
  
 }

 public function filter_search(Request $request){
    $search = array();
    if($request->has('city')){
      $search['city'] = $request->city;  
    }
    if($request->has('state')){
      $search['state'] = $request->city;  
    }
    if($request->has('country')){
      $search['country'] = $request->country;  
    }
    if($request->has('pincode')){
      $search['pincode'] = $request->pincode;  
    }
    if($request->has('from')){
      $search['created_at'] = $request->from;  
    }
    if($request->has('to')){
      $search['created_at'] = $request->to;  
    }

   $data =  DB::table('fatalities')->where(function($q) use ($search){
      foreach($search as $key => $value){
          $q->where($key, '=', $value);
      }
  })->get();
    return response()->json([
      "success" => true,
     'data'=>$data

      ],200);

 }

 function per_year_fatalities(Request $request){

   $data =  DB::select(" select SUM(fatalities) as fatalities from fatalities where DATE_FORMAT(created_at,'%Y') = $request->year group by created_at");

   return response()->json([
      "success" => true,
     'data'=>$data

      ],200);
 }

 


}
