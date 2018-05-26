<?php

namespace App\Http\Controllers\PenggunaAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UploadedFiles;
use DB;
use Auth;

class SegmentasiKataController extends Controller
{
    //

    public function __construct()
    {
    	# code...
    	$this->middleware('auth:pengguna');
    }

    public function segmentasi_kata($id_img_baris)
    {
    	# code...
    	$query_img = UploadedFiles::find($id_img_baris);

    	$html_img_line = '';

    	$filePath = $query_img->uploaded_file_path;

    	$baris_ke = $this->translate_file_path($filePath);

    	if($query_img->count()){

    		$src_gambar = asset('');

	        $src_gambar.=$query_img->uploaded_file_path;



	   		$html_img_line = ' <div class="card">
	                      <div class="card-image">
	                        <figure class="image is-512x512" >
	                          <img  src="'.$src_gambar.'" alt="Placeholder image">
	                        </figure>
	                      </div>
	                      <div class="card-content">
	                        <div class="media">
	                          <div class="media-content">
	                            <p class="title is-4" style="text-align: center;">Preview Baris '.$baris_ke.'</p>
	                          </div>
	                        </div>
	                      </div>

	                       <div class="content  has-text-centered">

	                     
	                      </div>
	                  </div>';

    	}

    	$user_id = Auth::user()->id;

    	$arr_kode_visual = array(
    		4,5
    		);

    	$query_visualisasi_segmentasi_kata = UploadedFiles::join('image_types','image_types.id_image_type','=','uploaded_files.uploaded_file_type')->where('uploaded_by_user','=',$user_id)
    														->whereIn('uploaded_file_type',$arr_kode_visual)
    														->get();

    	$final_query = array();

    	foreach ($query_visualisasi_segmentasi_kata as $segmentasi_kata) {
    		# code...

    		$trimmed = str_replace(".png", "", $segmentasi_kata->uploaded_file_path);

    		if (strpos($trimmed, 'baris_'.$baris_ke.'_visualisasi_segmentasi_kata_') !== false) {
			    array_push($final_query, $segmentasi_kata);
			}
    	}

    	$query_visualisasi_segmentasi_kata = $final_query;

    	$visualisasi_images = array();

    	foreach ($query_visualisasi_segmentasi_kata as $visualisasi_segmentasi_kata) {
    		# code...
    		$src_gambar = asset('');

	        $src_gambar.=$visualisasi_segmentasi_kata->uploaded_file_path;

	        $keterangan = $visualisasi_segmentasi_kata->image_type_name;

	        if(strpos($keterangan, "TAM")!=FALSE){
	        	$jenis_segmentasi = "segmentasi_kata_tam";
	        }

	        else if(strpos($keterangan, "IQM")!=FALSE){
	        	$jenis_segmentasi = "segmentasi_kata_iqm";
	        }

	        $html_img_visual = ' <div class="card">
	                      <div class="card-image">
	                        <figure class="image is-512x512" >
	                          <img  src="'.$src_gambar.'" alt="Placeholder image">
	                        </figure>
	                      </div>
	                      <div class="card-content">
	                        <div class="media">
	                          <div class="media-content">
	                            <p class="title is-4" style="text-align: center;">'.$keterangan.'</p>
	                          </div>
	                        </div>
	                      </div>

	                       <div class="content  has-text-centered">

	                       <a class="button is-success is-outlined btn-lihat-hasil-segmentasi-kata" data-idimgbaris='.$id_img_baris.'
	                        data-jenissegmentasi='.$jenis_segmentasi.'>Lihat Hasil</a>
	                     
	                      </div>
	                  </div>';

	        array_push($visualisasi_images, $html_img_visual);

    	}

    	return view('pengguna/segmentasi_kata',[
    		'html_img_line'=>$html_img_line,
    		'visualisasi_images'=>$visualisasi_images,
    		'id_img_baris'=>$id_img_baris
    		]);

    	
    }

    private function translate_file_path($filePath){
    	
    	$name = Auth::user()->name;

    	$target_str = $name."baris_";


    	$trimmed = str_replace($target_str, "", $filePath);

    	$trimmed = str_replace(".png", "", $trimmed);

    	return $trimmed;
    }
}

