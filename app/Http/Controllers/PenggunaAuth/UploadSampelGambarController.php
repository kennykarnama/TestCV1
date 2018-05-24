<?php

namespace App\Http\Controllers\PenggunaAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Carbon\Carbon;

class UploadSampelGambarController extends Controller
{
    //
    public function __construct()
    {
    	# code...
    	$this->middleware('auth:pengguna');
    }

    public function upload_sampel_gambar(Request $request)
    {
    	# code...

    	$cmd = "/usr/bin/rgb2binary "."/home/kenny/sampel_gambar/t26.png kenny_binary"." 2>&1";

    	$str = exec($cmd);

    	//echo $str;

    	$username = Auth::user()->name;

    	 $time = Carbon::now();
	    // Requesting the file from the form
	    $image = $request->file('upload-sampel-gambar');
	    // Getting the extension of the file 
	    $extension = $image->getClientOriginalExtension();
	    // Creating the directory, for example, if the date = 18/10/2017, the directory will be 2017/10/
	    $directory = date_format($time, 'Y') . '/' . date_format($time, 'm');
	    // Creating the file name: random string followed by the day, random number and the hour
	    $filename = $username."_sampel_gambar_".".".$extension;
	    // This is our upload main function, storing the image in the storage that named 'public'
	    $upload_success = $image->storeAs($directory, $filename, 'public');
	    // If the upload is successful, return the name of directory/filename of the upload.

	    $resp = array(
	    	);
	    if ($upload_success) {
	        $resp['data'] = $upload_success;
	        $resp['status'] = 200;
	        $resp['extras'] = $str;
	        return response()->json($resp);
	    }
	    // Else, return error 400
	    else {
	    	$resp['data'] = 'error';
	        $resp['status'] = 400;
	        return response()->json($resp);
	    }

    }
}
