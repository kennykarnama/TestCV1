<?php

namespace App\Http\Controllers\PenggunaAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\UploadedFiles;
use Carbon\Carbon;

class PengenalanController extends Controller
{
    //

    private $root_path;

    
    public function __construct()
    {
    	# code...
    	$this->middleware('auth:pengguna');

    	$this->root_path = "/var/www/html/TestCV1";

      
    }

   public function convert_to_binary_image(Request $request)
   {
   	# code...
   	 $id = Auth::user()->id;

   	 $name = Auth::user()->name;

   	 $query_uploaded_files = UploadedFiles::where('uploaded_by_user','=',$id)->get();

   	 $uploaded_file = $query_uploaded_files[0];

   	 $original_image = $this->root_path."/public/uploads/".$uploaded_file->uploaded_file_path;

   	  $cmd = "/usr/bin/rgb2binary ".$original_image." ".$name." 2>&1";

   	 $str = exec($cmd);

     if(strcmp($str, "error")!=0){

        DB::beginTransaction();

    try {

        // insert ke tabel uploaded_files

      $uploaded_by_user = Auth::user()->id;

      $uploaded_file_path = $str;

      $uploaded_file_extension = "png";

      $uploaded_file_type = 2;

      $uploaded_at = Carbon::now();

      $uploaded_files = new UploadedFiles;

      $uploaded_files->uploaded_file_path = $uploaded_file_path;

      $uploaded_files->uploaded_by_user = $uploaded_by_user;

      $uploaded_files->uploaded_file_type = $uploaded_file_type;

      $uploaded_files->uploaded_at = $uploaded_at;

      $uploaded_files->uploaded_file_extension = $uploaded_file_extension;

      $status = $uploaded_files->save();

        DB::commit();
        // all good
    } catch (\Exception $e) {
        DB::rollback();
        // something went wrong

        throw $e;
    }

     }

   	 return response()->json($str);


   }

   public function segment_line(Request $request)
   {
     # code...
      // cari file dengan user id dan jenis binary (2)

      $user_id = Auth::user()->id;

      $username = Auth::user()->name;

      $query_uploaded_files = UploadedFiles::where('uploaded_by_user','=',$user_id)
                                            ->where('uploaded_file_type','=',2)->get();

      $item_uploaded_files = $query_uploaded_files[0];

      $binary_image = $this->root_path."/public/".$item_uploaded_files->uploaded_file_path;

      $cmd = "/usr/bin/line_segmentation ".$binary_image." ".$username." 11"." 2>&1";

      $str = exec($cmd);

      $now = Carbon::now();

      if(strcmp($str, "error")!=0){
        
        $file_paths = explode(",", $str);

        $data = array();

        for($i=0;$i<count($file_paths);$i++){
          $nested = array(
              'uploaded_file_path'=>$file_paths[$i],
              'uploaded_by_user'=>$user_id,
              'uploaded_file_extension'=>'png',
              'uploaded_file_type'=>3,
              'uploaded_at'=>$now
            );

          array_push($data, $nested);
        }

        $status_insert = UploadedFiles::insert($data);

        if($status_insert)
          return response()->json($file_paths);

        else
          return response()->json("error");

      }

      else{

        return response()->json("error");

      }

     

   }

   public function allLines(Request $request)
   {
     # code...
        $jumlah_data = $this->countAllLines();

        $filteredData = $jumlah_data;

        // get data table request

        $limit = $request->input('length');
        
        $start = $request->input('start');

        if(($request->input('order.0.column'))!==NULL){
              
              $order = $columns[$request->input('order.0.column')];
              
              $dir = $request->input('order.0.dir');

        }

        // check search value

        if(empty($request->input('search.value'))){

            if(isset($order)&&isset($dir)){

              $lines = $this->fetchAllLines($start,$limit,$order,$dir); 
            }

            else{

                $lines = $this->fetchAllLines($start,$limit);
            }
        }


        $data = array();

        $puter = $start+1;

        foreach ($lines as $line) {
            # code...
            $nested_array['no'] = $puter++;

            $src_gambar = asset('');

            $src_gambar.=$line->uploaded_file_path;

            $nested_array['gambar'] = '<figure class="image is-128x128">
                                      <img src="'.$src_gambar.'">
                                    </figure>';
            $nested_array['actions'] = '<div class="buttons has-addons">
                                      <span class="button is-link is-large">Detail</span>
                                      <span class="button is-success is-large">Word Segmentation</span>
                                    </div>';

           array_push($data, $nested_array);

            
        }

        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($jumlah_data),  
                    "recordsFiltered" => intval($filteredData), 
                    "data"            => $data   
                    );

        return response()->json($json_data);

   }

   private function fetchAllLines($start,$limit){
      $query = UploadedFiles::where('uploaded_file_type','=',3)
                              ->where('uploaded_by_user','=',Auth::user()->id)
                              ->offset($start)
                              ->limit($limit)
                              ->get();

      return $query;
   }

    private function fetchAllLinesOrdered($start,$limit,$order,$dir){
      $query = UploadedFiles::where('uploaded_file_type','=',3)
                              ->where('uploaded_by_user','=',Auth::user()->id)
                              ->offset($start)
                              ->limit($limit)
                              ->orderBy($order,$dir)
                              ->get();

      return $query;
   }

  private function countAllLines(){
     $query = UploadedFiles::where('uploaded_file_type','=',3)
                              ->where('uploaded_by_user','=',Auth::user()->id)
                              ->count();

    return $query;
  }


}
