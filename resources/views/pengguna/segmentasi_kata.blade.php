@extends('pengguna.layout.general')

@section('content')
	
<div class="columns" id="mail-app">
	  <div class="column is-12 messages hero is-fullheight" id="message-feed">

	  <div class="box">

	  <nav class="breadcrumb" aria-label="breadcrumbs">
	  <ul>
	    <li><a href="#">Pengenalan</a></li>
	    <li><a href="#">Segmentasi Baris</a></li>
	    <li class="is-active"><a href="#" aria-current="page">Segmentasi Kata</a></li>
	  </ul>
	</nav>

	  <div class="columns is-multiline">
	  		<div class="column is-12">
	  			{!! $html_img_line !!}
	  		</div>
	  </div>

	  <div class="columns is-multiline">

	  		@foreach($visualisasi_images as $visualisasi_image)


	  		<div class="column is-12">
				{!! $visualisasi_image !!}  			
	  		</div>

	  		@endforeach
	  		
	  </div>
	  	
	  </div>
	  
	  </div>
</div>


@stop