<?php

namespace App\Http\Controllers\PenggunaAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class PengenalanController extends Controller
{
    //
    public function __construct()
    {
    	# code...
    	$this->middleware('auth:pengguna');
    }

   


}
