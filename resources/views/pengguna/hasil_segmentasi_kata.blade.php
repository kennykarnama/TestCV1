@extends('pengguna.layout.general')

@section('content')

<div class="pageloader is-right-to-left" id="page-loader">
<p style="text-align: center;">Please Wait...</p>
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

<script type="text/javascript">

function segment_characters(id_img_word,id_jenis_segmentasi) {
	// body...

	 $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

        $.ajax({
            url: "{{url('pengguna/pengenalan/segment_characters')}}",
            type: "POST",
            data: {

              "id_img_word":id_img_word,
              "jenis_operasi":"proyeksi_nol"
                        
            },
            dataType: "json",
            success: function (data) {



            	//console.log(data);
                
                $('#page-loader').removeClass('is-active');
                
            	var url = "{{url('pengguna/segmentasi_karakter/{id_img_word}/{id_jenis_segmentasi}')}}";

				url = url.replace('{id_img_word}',id_img_word);

				url = url.replace('{id_jenis_segmentasi}',id_jenis_segmentasi);

				var win = window.open(url,"_blank");
               	
                
            }
            
        });

}

function visualisasi_segmentasi_karakter(id_img_word,id_jenis_segmentasi) {
		// body...

		$('#page-loader').addClass('is-active');
		  $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

        $.ajax({
            url: "{{url('pengguna/pengenalan/visualize_segmented_characters')}}",
            type: "POST",
            data: {

              "id_img_word":id_img_word,
              "jenis_operasi":"visualisasi"
                        
            },
            dataType: "json",
            success: function (data) {



    //         	console.log(data);
                
    //         	var url = "{{url('pengguna/segmentasi_karakter/{id_img_word}/{id_jenis_segmentasi}')}}";

				// url = url.replace('{id_img_word}',id_img_word);

				// url = url.replace('{id_jenis_segmentasi}',id_jenis_segmentasi);

				// var win = window.open(url,"_blank");

				if(data!="error"){
					segment_characters(id_img_word,id_jenis_segmentasi);
				}
               	
                
            }
            
        });
	}


	$(document).ready(function () {
		// body...
		$('.btn-lihat-hasil-segmentasi-karakter').click(function () {
			// body...

			var id_img_word = $(this).data('idimgword');

			var id_jenis_segmentasi = "{{$id_jenis_segmentasi}}";
			
			//alert(id_img_word+" "+id_jenis_segmentasi);
			visualisasi_segmentasi_karakter(id_img_word,id_jenis_segmentasi);
		});
	});
</script>


@stop