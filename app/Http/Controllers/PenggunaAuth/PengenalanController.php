<?php

namespace App\Http\Controllers\PenggunaAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\UploadedFiles;

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

   	 return response()->json($str);


   }

   


}
