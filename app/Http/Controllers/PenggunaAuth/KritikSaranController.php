<?php

namespace App\Http\Controllers\PenggunaAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\KritikSaran;
use Carbon\Carbon;

class KritikSaranController extends Controller
{
    //
    public function __construct()
    {
    	# code...
    	$this->middleware('auth:pengguna');
    }

    public function kirim_kritik_saran(Request $request)
    {
    	# code...
    	$konten = $request['konten'];

    	$sent_by_user = Auth::user()->id;

    	$now = Carbon::now();

    	$created_at = $now;

    	$kritik_saran = new KritikSaran;

    	$kritik_saran->konten = $konten;

    	$kritik_saran->sent_by_user = $sent_by_user;

    	$kritik_saran->created_at = $created_at;

    	$status = $kritik_saran->save();

    	if($status)
    		return 1;
    	return 0;

    }
}
