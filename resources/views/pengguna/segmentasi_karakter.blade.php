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
	  	<li><a href="#">{{$nama_segmentasi_kata}}</a></li>
	  	<li class="is-active"><a href="#" aria="current-page">Segmentasi Karakter</a></li>
	  
	  </ul>
	</nav>

	 <div class="columns is-multiline">

	  		@foreach($list_visualisasi_karakter as $visualisasi_karakter)


	  		<div class="column is-12">
				{!! $visualisasi_karakter !!}  			
	  		</div>

	  		@endforeach
	  		
	  </div>
	 
	  	
	  </div>
	  
	  </div>
</div>

<script type="text/javascript">
	
	

	$(document).ready(function () {
		// body...

		visualisasi_segmentasi_karakter();
	});
</script>

@stop

