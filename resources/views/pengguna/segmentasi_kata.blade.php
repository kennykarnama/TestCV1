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



<script type="text/javascript">

function lihat_hasil_segmentasi(id_img_baris,jenis_segmentasi) {
	// body...
	  $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

        $.ajax({
            url: "{{url('pengguna/pengenalan/segment_words')}}",
            type: "POST",
            data: {

                "id_img_baris":id_img_baris,
                "jenis_segmentasi":jenis_segmentasi
                        
            },
            dataType: "json",
            success: function (data) {

            	console.log(data);
                

               if(data!="error"){
               

               }

               else{
               	toastr.error("Error","Segmentasi Kata gagal");
               }

                
            }
            
        });
}
	
	$(document).ready(function () {
		// body...
		$('.btn-lihat-hasil-segmentasi-kata').click(function () {
			// body...
			var id_img_baris = $(this).data('idimgbaris');

			var jenis_segmentasi = $(this).data('jenissegmentasi');

			//alert(id_img_baris+" "+jenis_segmentasi);
			lihat_hasil_segmentasi(id_img_baris,jenis_segmentasi);
		});
	});
</script>


@stop