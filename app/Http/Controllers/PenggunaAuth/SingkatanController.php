<?php

namespace App\Http\Controllers\PenggunaAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Singkatan;
use Carbon\Carbon;


class SingkatanController extends Controller
{
    //

    public function __construct()
    {
    	# code...
    	 $this->middleware('auth:pengguna');
    }

    public function allPengajuanSingkatan(Request $request)
    {
    	# code...
    	$columns = array(
			1=>'kata_singkatan',
			2=>'makna_singkatan',
			3=>'created_at'
            
			);

    	$id_user = Auth::user()->id;

		// hitung jumlah data

        $jumlah_data = $this->hitung_pengajuan_singkatan($id_user);

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

            	$list_pengajuan_singkatan = $this->fetch_pengajuan_singkatan_order($start,$limit,$id_user,$order,$dir);
                }

            else{

                $list_pengajuan_singkatan = $this->fetch_pengajuan_singkatan($start,$limit,$id_user);

            }
        }

        else{

            $search_value = $request->input('search.value');

            if(isset($order)&&isset($dir)){

            	 $list_pengajuan_singkatan = $this->fetch_pengajuan_singkatan_filtered_ordered($start,$limit,$id_user,$search_value,$order,$dir);

            	
            }

            else{

            	$list_pengajuan_singkatan = $this->fetch_pengajuan_singkatan_filtered($start,$limit,$id_user,$search_value);    
              
            }

             $totalFiltered = $this->hitung_pengajuan_singkatan_filtered($id_user,$search_value);
        }

        $data = array();

        $puter = $start+1;

        foreach ($list_pengajuan_singkatan as $pengajuan_singkatan) {
            # code...
          	$nested_array['no'] = $puter++;

          	$nested_array['kata_singkatan'] = $pengajuan_singkatan->kata_singkatan;

          	$nested_array['makna_singkatan'] = $pengajuan_singkatan->makna_singkatan;

          	$nested_array['tanggal_pengajuan'] = $pengajuan_singkatan->created_at;

          	$str_status;

          	if($pengajuan_singkatan->is_approved == 0){
          		$str_status = '<span class="icon">
						      		<i class="fa fa-window-close"></i>
						    	</span>';
			}

			else{

				$str_status = '<span class="icon">
						      		<i class="fa fa-check"></i>
						    	</span>';

			}

          	$nested_array['status'] = $str_status;

          	$is_disabled_button = "";

          	if($pengajuan_singkatan->is_approved != 0){
          		$is_disabled_button = "disabled";
          	}	

          	$nested_array['actions'] = '<a class="button is-danger btn-batalkan-pengajuan"'.$is_disabled_button.' data-idsingkatan="'.$pengajuan_singkatan->id_singkatan.'">Batalkan</a>';

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



    public function ajukan_singkatan(Request $request)
    {
    	# code...
    	$kata_singkatan = $request['kata_singkatan'];

    	$makna_singkatan = $request['makna_singkatan'];

    	$proposed_by_user = Auth::user()->id;

    	$now = Carbon::now();

    	$singkatan = new Singkatan;

    	$singkatan->kata_singkatan = $kata_singkatan;

    	$singkatan->makna_singkatan = $makna_singkatan;

    	$singkatan->proposed_by_user = $proposed_by_user;

    	$singkatan->created_at = $now;

    	$status = $singkatan->save();

    	if($status)
    		return 1;
    	else
    		return 0;

    }

    public function batalkan_pengajuan(Request $request)
    {
    	# code...
    	$id_singkatan = $request['id_singkatan'];

    	$singkatan = Singkatan::find($id_singkatan);

    	$now = Carbon::now();

    	$singkatan->deleted_at = $now;

    	$status = $singkatan->save();

    	if($status)
    		return 1;
    	else
    		return 0;

    }

    public function hitung_pengajuan_singkatan($id_user)
    {
    	# code...
    	$query = Singkatan::whereNull('deleted_at')
    						->where('proposed_by_user','=',$id_user)
    						->count();

    	return $query;
    }

    public function hitung_pengajuan_singkatan_filtered($id_user,$search_value)
    {
    	# code...
    	$query = Singkatan::where('kata_singkatan','LIKE','%'.$search_value.'%')
    						->orWhere('makna_singkatan','LIKE','%'.$search_value.'%')
    						->get();


    	$final_query = array();

    	foreach ($query as $item) {
    		# code...
    		if(is_null($item->deleted_at) && $item->proposed_by_user == $id_user){
    			array_push($final_query, $item);
    		}
    	}

    	return count($final_query);

    }

    public function fetch_pengajuan_singkatan($offset,$limit,$id_user)
    {
    	# code...

    	$query = Singkatan::whereNull('deleted_at')
    						->where('proposed_by_user','=',$id_user)
    						->offset($offset)
    						->limit($limit)
    						->get();

    	return $query;


    }

    public function fetch_pengajuan_singkatan_order($offset,$limit,$id_user,$order,$dir)
    {
    	# code...

    	$query = Singkatan::whereNull('deleted_at')
    						->where('proposed_by_user','=',$id_user)
    						->offset($offset)
    						->limit($limit)
    						->orderBy($order,$dir)
    						->get();

    	return $query;


    }

    public function fetch_pengajuan_singkatan_filtered($offset,$limit,$id_user,$search_value)
    {
    	# code...
    	$query = Singkatan::where('kata_singkatan','LIKE','%'.$search_value.'%')
    						->orWhere('makna_singkatan','LIKE','%'.$search_value.'%')
    						->offset($offset)
    						->limit($limit)
    						->get();

    	$final_query = array();

    	foreach ($query as $item) {
    		# code...
    		if(is_null($item->deleted_at) && $item->proposed_by_user == $id_user){
    			array_push($final_query, $item);
    		}
    	}

    	return $final_query;
    }

    public function fetch_pengajuan_singkatan_filtered_ordered($offset,$limit,$id_user,$search_value,$order,$dir)
    {
    	# code...
    	$query = Singkatan::where('kata_singkatan','LIKE','%'.$search_value.'%')
    						->orWhere('makna_singkatan','LIKE','%'.$search_value.'%')
    						->offset($offset)
    						->limit($limit)
    						->orderBy($order,$dir)
    						->get();

    	$final_query = array();

    	foreach ($query as $item) {
    		# code...
    		if(is_null($item->deleted_at) && $ite->proposed_by_user == $id_user){
    			array_push($final_query, $item);
    		}
    	}

    	return $final_query;


    }


}
