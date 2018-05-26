<?php

namespace App\Http\Controllers\PenggunaAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\UploadedFiles;

class SegmentasiBarisController extends Controller
{
    //

    public function __construct()
    {
    	# code...
    	$this->middleware('auth:pengguna');
    }

    public function index()
    {
    	# code...
    	$lines = $this->fetchAllLines();

    	$img_lines = array();

    	$puter = 1;



    	foreach ($lines as $line) {
    		# code...
    		$src_gambar = asset('');

        $src_gambar.=$line->uploaded_file_path;

    		$html_img_line = ' <div class="card">
                      <div class="card-image">
                        <figure class="image is-512x512" >
                          <img  src="'.$src_gambar.'" alt="Placeholder image">
                        </figure>
                      </div>
                      <div class="card-content">
                        <div class="media">
                          <div class="media-content">
                            <p class="title is-4" style="text-align: center;">Baris'.$puter++.'</p>
                          </div>
                        </div>
                      </div>

                       <div class="content  has-text-centered">

                       <a class="button is-outlined is-success btn-segmentasi-kata" style="margin-bottom: 15px;" 
                       data-idimgbaris='.$line->id_uploaded_file.'>Word Segmentation</a>
                     
                      </div>
                  </div>';
            array_push($img_lines, $html_img_line);

    	}

    	return view('pengguna/segmentasi_baris',[
    		'img_lines'=>$img_lines
    		]);
    }

    private function fetchAllLines(){
      $query = UploadedFiles::where('uploaded_file_type','=',3)
                              ->where('uploaded_by_user','=',Auth::user()->id)
                              ->get();

      return $query;
   }



}
