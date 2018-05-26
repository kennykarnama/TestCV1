@extends('pengguna.layout.general')

@section('content')

<div class="pageloader is-right-to-left" id="page-loader">
Please Wait
</div>
<div class="columns" id="mail-app">
	  <div class="column is-12 messages hero is-fullheight" id="message-feed">

	  <div class="box">

	  <nav class="breadcrumb" aria-label="breadcrumbs">
	  <ul>
	    <li><a href="#">Pengenalan</a></li>
	    <li><a href="#">Segmentasi Baris</a></li>
	  	<li><a href="#">Segmentasi Kata</a></li>
	  	<li class="is-active"><a href="#" aria-current="page">{{$jenis_segmentasi_yg_digunakan}}</a></li>
	  	
	  </ul>
	</nav>

	<div class="columns is-multiline">

		@foreach($list_words as $word)
			<div class="column is-4">
				{!! $word !!}
			</div>	
		@endforeach
		
	</div>

	  
	  	
	  </div>
	  
	  </div>
</div>


@stop