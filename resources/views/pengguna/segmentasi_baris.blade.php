@extends('pengguna.layout.general')

@section('content')

<div class="pageloader is-right-to-left" id="page-loader">

</div>
<div class="columns" id="mail-app">
	  <div class="column is-12 messages hero is-fullheight" id="message-feed">

	  <div class="box">

	  <nav class="breadcrumb" aria-label="breadcrumbs">
	  <ul>
	    <li><a href="#">Pengenalan</a></li>
	    <li class="is-active"><a href="#" aria-current="page">Segmentasi Baris</a></li>
	  </ul>
	</nav>

	  <div class="columns is-multiline">
	  	@foreach($img_lines as $img_line)
	  		<div class="column is-12">
	  			{!! $img_line !!}
	  		</div>
	  	@endforeach
	  </div>
	  	
	  </div>
	  
	  </div>
</div>

<div class="modal" id="modal-pesan-segmentasi-kata">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Segmentasi Kata</p>
      <button class="delete btn-tutup-modal" aria-label="close"></button>
    </header>
    <section class="modal-card-body">
      <!-- Content ... -->
      <p>Segmentasi Kata telah selesai</p>


    </section>
    <footer class="modal-card-foot">
      <a class="button is-success" href="" target="_blank" id="btn-lihat-hasil-segmentasi-kata"> Lihat Hasil </a>
      <button class="button btn-tutup-modal">Tutup</button>
    </footer>
  </div>
</div>






<script type="text/javascript">

function segmentasi_kata(id_img_baris) {
	// body...

	$('#page-loader').addClass('is-active');

	  $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

        $.ajax({
            url: "{{url('pengguna/pengenalan/visualize_segmented_words')}}",
            type: "POST",
            data: {

                "id_img_baris":id_img_baris
                        
            },
            dataType: "json",
            success: function (data) {

            	console.log(data);
                

               if(data!="error"){

               	$('#page-loader').removeClass('is-active');

               $('#modal-pesan-segmentasi-kata').addClass('is-active');
               

               }

               else{
               	toastr.error("Error","Segmentasi Kata gagal");
               }

                
            }
            
        });
}

function deskew(id_img_baris) {
  // body...
 
   swal({
        title: "Skew Correction menggunakan entropy",
        text: "Apakah anda yakin ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "De-skew",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;

        $('#page-loader').html("<span class='title'>Please Wait, De-skewing...</span>");

        $('#page-loader').addClass('is-active');

        $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

        $.ajax({
            url: "/pengguna/pengenalan/deskew",
            type: "POST",
            data: {

             "id_img_baris":id_img_baris
                  
            },
            dataType: "json",
            success: function (data) {

            	$('#page-loader').removeClass('is-active');
            	
            	if(data!="error"){


            		location.reload();

            	}

            	else{
            		  swal("Failed!", "Gagal melakukan deskew", "error");
            	}
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Failed!", "Gagal melakukan deskew", "error");

                console.log(thrownError);
            }
        });
    });
}

function rerun_line_segmentation(id_img_baris) {
  // body...
 
   swal({
        title: "Rerun Line Segmentation",
        text: "Apakah anda yakin ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Segment",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;

        // $('#page-loader').html("<span class='title'>Please Wait, De-skewing...</span>");

        // $('#page-loader').addClass('is-active');

        $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

        $.ajax({
            url: "/pengguna/pengenalan/segment_line",
            type: "POST",
            data: {

             "id_img_baris":id_img_baris,
             "jenis_segmentasi_baris":"revisi"
                  
            },
            dataType: "json",
            success: function (data) {

            	
            	
            	if(data!="error"){


            		location.reload();

            	}

            	else{
            		  swal("Failed!", "Gagal melakukan segmentasi ulang", "error");
            	}
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Failed!", "Gagal melakukan segmentasi ulang", "error");

                console.log(thrownError);
            }
        });
    });
}
	$(document).ready(function () {
		// body...
		$('.btn-segmentasi-kata').click(function () {
			// body...
			
			var id_img_baris = $(this).data('idimgbaris');

			var url = "{{url('/pengguna/segmentasi_kata/[id_img_baris]')}}";

			url = url.replace("[id_img_baris]",id_img_baris);


			$('#btn-lihat-hasil-segmentasi-kata').attr('href',url);

			segmentasi_kata(id_img_baris);

			
		});

		$('.btn-tutup-modal').click(function () {
			// body...
			$('.modal').removeClass('is-active');
		});

		$('.btn-deskew').click(function () {
			// body...
			var id_img_baris = $(this).data('idimgbaris');

			deskew(id_img_baris);
		});

		$('.btn-rerun-segmentasi-baris').click(function () {
			// body...
			var id_img_baris = $(this).data('idimgbaris');

			rerun_line_segmentation(id_img_baris);

		});
	})
</script>
@stop