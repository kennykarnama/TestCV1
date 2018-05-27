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

	    <div class="columns is-multiline">

	  		@foreach($list_karakter as $karakter)


	  		<div class="column is-4">
				{!! $karakter !!}  			
	  		</div>

	  		@endforeach
	  		
	  </div>
	 
	  	
	  </div>
	  
	  </div>
</div>

<div class="modal" id="modal-detail-pengenalan">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Pengenalan</p>
      <button class="delete btn-tutup-modal" aria-label="close"></button>
    </header>
    <section class="modal-card-body">
      <!-- Content ... -->
      <table class="table is-bordered is-fullwidth" id="tabel_detail_pengenalan">
      	<thead>
      		<tr>
      			<th>Karakter</th>
      			<th>Nilai Neural Network</th>
      			<th>Status</th>
      		</tr>
      	</thead>
      	<tbody></tbody>
      </table>
    </section>
    <footer class="modal-card-foot">
      <button class="button btn-tutup-modal is-danger">Tutup</button>
    </footer>
  </div>
</div>


<script type="text/javascript" src="{{asset('animated-modal-js/animatedModal.min.js')}}"></script>

<script type="text/javascript">

function populate_table(id_tabel,data) {
	// body...
	
	$(id_tabel + " tbody").empty();

	var arr = $.map(data, function(el) { return el });

	//var arr = JSON.parse(data);

	// cari indeks maks

	var maks = -1;

	var indeks = -1;

	for(var i=0;i< arr.length;i++){
		if(maks < arr[i]){
			maks = arr[i];
			indeks = i;
		}
	}

	//console.log(maks);

	arr.forEach(function (value, i) {

		//console.log(i+" "+value);

		var attribut = "";
		if(i==indeks){
			attribut = '<span class="icon has-text-success"><i class="fa fa-check-square"></i></span>';

		}
		else{
			attribut = '<span class="icon has-text-danger"><i class="fa fa-ban"></i></span>';
		}

    	$(id_tabel + " tbody").append("<tr>"+"<td>"+String.fromCharCode(97 + i)+"</td>"+"<td>"+value+"</td>"+"<td>"+attribut+"</td>"+"</tr>");
	});

	//console.log(arr);
}
	
	function recognize(id_char_img) {
		// body...
		$.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

        $.ajax({
            url: "{{url('pengguna/pengenalan/recognize')}}",
            type: "POST",
            data: {

              "id_img_character":id_char_img
                        
            },
            dataType: "json",
            success: function (data) {



            	console.log(data);

            	populate_table("#tabel_detail_pengenalan",data);
                
                $('#modal-detail-pengenalan').addClass('is-active');
              
               	
                
            }
            
        });
	}

	$(document).ready(function () {
		// body...

		$('.btn-kenali').click(function () {
			// body...
			var id_img_character = $(this).data('idimgcharacter');

			recognize(id_img_character);
		});

		$('.btn-tutup-modal').click(function () {
			// body...
			$('.modal').removeClass('is-active');
		});

			

	});
</script>

@stop

