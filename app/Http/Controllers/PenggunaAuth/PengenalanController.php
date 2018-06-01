<?php

namespace App\Http\Controllers\PenggunaAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\UploadedFiles;
use App\HasilPengenalan;
use Carbon\Carbon;

class PengenalanController extends Controller
{
    //

    private $root_path;

    private $alphabets;

    
    public function __construct()
    {
    	# code...
    	$this->middleware('auth:pengguna');

    	$this->root_path = "/var/www/html/TestCV1";

      $this->alphabets = array();

      for($i=0;$i < 26; $i++){
        $this->alphabets[chr((97+$i))] = 0;
      }
      
    }

    public function deskew(Request $request)
    {
      # code...
      $id_img_baris = $request['id_img_baris'];

      $query_uploaded_files = UploadedFiles::find($id_img_baris);

      if($query_uploaded_files->count()){
          
          $line_img = $this->root_path."/public/".$query_uploaded_files->uploaded_file_path;

          $nama_file = $query_uploaded_files->uploaded_file_path;

          $nama_file = str_replace(".png", "", $nama_file);

          $cmd = "/usr/bin/skew_correction ".$line_img." ".$nama_file." 2>&1";

          $str = exec($cmd);

          $resp = explode(";", $str);

          return response()->json($resp);

      }

      return response()->json("error");
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

    $jenis_segmentasi_baris = $request['jenis_segmentasi_baris'];



      $user_id = Auth::user()->id;

      $username = Auth::user()->name;

      if(strcmp($jenis_segmentasi_baris, "revisi")==0){

        $id_img_baris = $request['id_img_baris'];

        $query_uploaded_files = UploadedFiles::find($id_img_baris);

        $item_uploaded_files = $query_uploaded_files;

        $part_cmd = $jenis_segmentasi_baris." ".$this->root_path."/public/";
      }

      else{

        $query_uploaded_files = UploadedFiles::where('uploaded_by_user','=',$user_id)
                                            ->where('uploaded_file_type','=',2)->get();

        $item_uploaded_files = $query_uploaded_files[0];

        $part_cmd = $jenis_segmentasi_baris;
      }

      
      

      $binary_image = $this->root_path."/public/".$item_uploaded_files->uploaded_file_path;

      $cmd = "/usr/bin/line_segmentation ".$binary_image." ".$username." ".$part_cmd." 2>&1";



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

   public function visualize_segmented_words(Request $request)
   {
     # code...

    $id_uploaded_file = $request['id_img_baris'];

      $user_id = Auth::user()->id;

      $username = Auth::user()->name;

      $query_uploaded_files = UploadedFiles::where('uploaded_by_user','=',$user_id)
                                            ->where('uploaded_file_type','=',3)
                                            ->where('id_uploaded_file','=',$id_uploaded_file)
                                            ->get();

      

      $item_uploaded_files = $query_uploaded_files[0];

      $word_image = $this->root_path."/public/".$item_uploaded_files->uploaded_file_path;

      $nama_file =  str_replace(".png", "", $item_uploaded_files->uploaded_file_path);

       $cmd = "/usr/bin/word_segmentation ".$word_image." ".$nama_file." visualisasi"." 2>&1";

       $str = exec($cmd);

       $now = Carbon::now();

       if(strcmp($str, "error")!=0){

          $file_paths = explode(",", $str);



          
          DB::beginTransaction();

          try {
              
              $this->insert_into_uploaded_files($file_paths[0],4,$now);
              
              $this->insert_into_uploaded_files($file_paths[1],5,$now);
              
  
              DB::commit();


              // all good
          } catch (\Exception $e) {
              DB::rollback();
              // something went wrong

              $str = "error";

              throw $e;
          }
       }  



      return response()->json($str);

   }



   public function segment_words(Request $request)
   {
     # code...
     $id_uploaded_file = $request['id_img_baris'];

     $jenis_segmentasi = $request['jenis_segmentasi'];


      $user_id = Auth::user()->id;

      $username = Auth::user()->name;

      $query_uploaded_files = UploadedFiles::where('uploaded_by_user','=',$user_id)
                                            ->where('uploaded_file_type','=',3)
                                            ->where('id_uploaded_file','=',$id_uploaded_file)
                                            ->get();

      

      $item_uploaded_files = $query_uploaded_files[0];

      $word_image = $this->root_path."/public/".$item_uploaded_files->uploaded_file_path;

      $nama_file =  str_replace(".png", "", $item_uploaded_files->uploaded_file_path);

       $cmd = "/usr/bin/word_segmentation ".$word_image." ".$nama_file." ".$jenis_segmentasi." 2>&1";

       $str = exec($cmd);

       $now = Carbon::now();

       if(strcmp($str, "error")!=0){

         if(strcmp($jenis_segmentasi, "segmentasi_kata_tam")==0){

          $status = $this->bulk_insert_into_uploaded_files($str,6);

         }

         else if(strcmp($jenis_segmentasi, "segmentasi_kata_iqm")==0){

          $status = $this->bulk_insert_into_uploaded_files($str,7);

         }

         if(!$status)
          $str = "error";
         
       }  



      return response()->json($str);

   }

   public function visualize_segmented_characters(Request $request)
   {
     # code...
    $id_img_word = $request['id_img_word'];

    $jenis_operasi = $request['jenis_operasi'];

    $query_img_word = UploadedFiles::find($id_img_word);

    $str = "";

    if($query_img_word->count()){

      $word_image = $this->root_path."/public/".$query_img_word->uploaded_file_path;

      $nama_file = str_replace(".png", "", $query_img_word->uploaded_file_path);


       $cmd = "/usr/bin/character_segmentation ".$word_image." ".$nama_file." ".$jenis_operasi." 2>&1";

       $str = exec($cmd);

       if(strcmp($str, "error") != 0){
         $status =  $this->bulk_insert_into_uploaded_files($str,9);

         if(!$status)
            $str = "error";
       }

       



    }

    else{

      $str = "error";

    }

    return response()->json($str);

   }

   public function segment_characters(Request $request)
   {
     # code...
     $id_img_word = $request['id_img_word'];

    $jenis_operasi = $request['jenis_operasi'];

    $query_img_word = UploadedFiles::find($id_img_word);

    $str = "";

    if($query_img_word->count()){

      $word_image = $this->root_path."/public/".$query_img_word->uploaded_file_path;

      $nama_file = str_replace(".png", "", $query_img_word->uploaded_file_path);


       $cmd = "/usr/bin/character_segmentation ".$word_image." ".$nama_file." ".$jenis_operasi." 2>&1";

       $str = exec($cmd);

       if(strcmp($str, "error") != 0){
         $status =  $this->bulk_insert_into_uploaded_files($str,8);

         if(!$status)
            $str = "error";
       }

       



    }

    else{

      $str = "error";

    }

    return response()->json($str);

   }

   public function recognize(Request $request)
   {
     # code...
      
      $id_img_character = $request['id_img_character'];

      $query_img_character = UploadedFiles::find($id_img_character);

       $char_image = $this->root_path."/public/".$query_img_character->uploaded_file_path;

       //return response()->json($char_image);
       $cmd = "/usr/bin/neural_network ".$char_image." 2>&1";

       $str = exec($cmd);

       if(strcmp($str, "error")!=0){

          $target_outputs = array_map("doubleval", explode(";", $str));

          for($i=0;$i<count($this->alphabets);$i++){
            $this->alphabets[chr(97+$i)] = $target_outputs[$i];
          }

          if(count($target_outputs)>0){
            $hasil_pengenalan = new HasilPengenalan;

            $hasil_pengenalan->id_img_character = $id_img_character;

            $hasil_pengenalan->target_outputs = $str;

            $hasil_pengenalan->created_at = Carbon::now();

            $status = $hasil_pengenalan->save();

            if($status){
               return response()->json($this->alphabets);
            }

            else{
              return response()->json("error");
            }
          }

         


       }

       else{

        return response()->json($str);
 
       }

       

   }

   

   private function insert_into_uploaded_files($file_path,$file_type,$now){
      $uploaded_files = new UploadedFiles;

      $uploaded_files->uploaded_file_path = $file_path;

      $uploaded_files->uploaded_by_user = Auth::user()->id;

      $uploaded_files->uploaded_file_extension = 'png';

      $uploaded_files->uploaded_file_type = $file_type;

      $uploaded_files->uploaded_at = $now;

      return $uploaded_files->save();
   }

   private function bulk_insert_into_uploaded_files($output_str,$file_type){

    $file_paths = explode(",", $output_str);

    $user_id = Auth::user()->id;

    $now = Carbon::now();

    $data = array();

        for($i=0;$i<count($file_paths);$i++){
          $nested = array(
              'uploaded_file_path'=>$file_paths[$i],
              'uploaded_by_user'=>$user_id,
              'uploaded_file_extension'=>'png',
              'uploaded_file_type'=>$file_type,
              'uploaded_at'=>$now
            );

          array_push($data, $nested);
        }

    return UploadedFiles::insert($data);

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
