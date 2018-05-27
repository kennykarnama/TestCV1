<?php

namespace App\Http\Controllers\PenggunaAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\UploadedFiles;

class SegmentasiKarakterController extends Controller
{
    //
    public function __construct()
    {
    	# code...
    	$this->middleware('auth:pengguna');
    }

    public function index($id_img_word,$id_jenis_segmentasi)
    {
    	# code...
    	$nama_segmentasi_kata = "";

    	if($id_jenis_segmentasi == 6)
    		$nama_segmentasi_kata = "TAM";

    	else if($id_jenis_segmentasi == 7)
    		$nama_segmentasi_kata = "IQM";

    	$query_img_word = UploadedFiles::find($id_img_word);

    	$trimmed = str_replace(".png", "", $query_img_word->uploaded_file_path);

    	$query_visualisasi_segmentasi_karakter = UploadedFiles::where('uploaded_by_user','=',Auth::user()->id)
    												            ->where('uploaded_file_type','=',9)
    												            ->where('uploaded_file_path','LIKE','%'.$trimmed.'%')
    												            ->where('id_uploaded_file','!=',$id_img_word)
    												            ->limit(1)
    												            ->get();


    	//$query_visualisasi_segmentasi_karakter = $query_visualisasi_segmentasi_karakter[1];
    	

    	$list_visualisasi_karakter = array();

    	foreach ($query_visualisasi_segmentasi_karakter as $visualisasi_segmentasi_karakter) {
    		# code...
    		$src_gambar = asset('');

                $src_gambar.=$visualisasi_segmentasi_karakter->uploaded_file_path;

                 $html_img_word = '<div class="card">
                          <div class="card-image">
                            <figure class="image is-128x128" >
                              <img  src="'.$src_gambar.'" alt="Placeholder image">
                            </figure>
                          </div>
                          <div class="card-content">
                            <div class="media">
                              <div class="media-content">
                                <p class="title is-4" style="text-align: center;"> Kata '.'Visualisasi Segmentasi Karakter'.'</p>
                              </div>
                            </div>
                          </div>

                           <div class="content  has-text-centered">
                         
                          </div>
                      </div>';

                array_push($list_visualisasi_karakter, $html_img_word);
    	}

    	return view('pengguna.segmentasi_karakter',[
    			'id_img_word'=>$id_img_word,
    			'id_jenis_segmentasi'=>$id_jenis_segmentasi,
    			'nama_segmentasi_kata'=>$nama_segmentasi_kata,
    			'list_visualisasi_karakter'=>$list_visualisasi_karakter
    		]);
    }
}

