@extends('pengguna.layout.general')

@section('content')

<style type="text/css">
  th.dt-center, td.dt-center { text-align: center; }
</style>
 <div class="columns" id="mail-app">
        <aside class="column is-3 aside hero is-fullheight">
            <div>
               
                <div class="main">
                    <a class="item active" id="li-pengenalan"><span class="icon"><i class="fa fa-eye"></i></span><span class="name">Pengenalan</span></a>
                    <a class="item" id="li-singkatan"><span class="icon"><i class="fa fa-font"></i></span><span class="name">Singkatan</span></a>
                    <a  class="item" id="li-kritik-saran"><span class="icon"><i class="fa fa-envelope-o"></i></span><span class="name">Kritik dan Saran</span></a>
                   
                </div>
            </div>
        </aside>
        <div class="column is-9 messages hero is-fullheight" id="message-feed">
           
           
               <div class="box box-pengenalan" id="box-pengenalan">

              
                   <div class="file">
                    <label class="file-label">
                      <input class="file-input" type="file" name="upload-sampel-gambar" id="upload-sampel-gambar">
                      <span class="file-cta">
                        <span class="file-icon">
                          <i class="fa fa-upload"></i>
                        </span>
                        <span class="file-label">
                          Choose a file…
                        </span>
                      </span>
                    </label>
                  </div>

                  <progress class="progress is-success" id="progress_upload_file" value="0" max="100" style="margin-top: 15px;">60%</progress>
               </div>

              
               <div class="columns box-pengenalan">
                 <div class="column" >
                   <div class="card">
                      <div class="card-image">
                        <figure class="image is-4by3" >
                          <img id="original_image" src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
                        </figure>
                      </div>
                      <div class="card-content">
                        <div class="media">
                          <div class="media-content">
                            <p class="title is-4" style="text-align: center;">Original Image</p>
                          </div>
                        </div>
                      </div>

                       <div class="content  has-text-centered">

                       <a class="button is-outlined is-success" style="margin-bottom: 15px;" id="btn-ubah-ke-binary">To Binary Image</a>
                     
                      </div>
                  </div>
                </div>

               <div class="column">
                     <div class="card">
                      <div class="card-image">
                        <figure class="image is-4by3">
                          <img id="binary_image" src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
                        </figure>
                      </div>
                      <div class="card-content">
                        <div class="media">
                          <div class="media-content">
                            <p class="title is-4" style="text-align: center;">Binary Image</p>
                          </div>
                        </div>
                      </div>

                       <div class="content has-text-centered">

                       <a class="button is-outlined is-success" id="btn-segment-line" style="margin-bottom: 15px;">Line Segmentation</a>
                     
                      </div>
                  </div>
                 </div>
           
               </div>

               

          

            <div class="box" id="box-singkatan" style="display: none;">

          

            <a class="button is-primary is-outlined" id="btn-pengajuan-singkatan" style="margin-bottom: 15px;">Ajukan Singkatan</a>

            <table class="table is-bordered" id="tabel_pengajuan_singkatan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Singkatan Yang Diajukan</th>
                        <th>Arti Sebenarnya</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody></tbody>
            </table>

             </div>
  
               
          

           <div class="box" id="box-kritik-saran" style="display: none;">

           <div class="field">
              <div class="control">
                <textarea class="textarea is-primary" type="text" placeholder="Kritik dan Saran" id="kritik_saran"></textarea>
              </div>
            </div>

            <a class="button" id="btn-kirim-kritiksaran">
            <span class="icon">
              <i class="fa fa-paper-plane"></i>
            </span>
            <span>Send</span>
          </a>
               
           </div>
           
        </div>
       
</div>

<div class="modal" id="modal-pengajuan-singkatan">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Ajukan Singkatan</p>
      <button class="delete btn-tutup-modal" aria-label="close"></button>
    </header>
    <section class="modal-card-body">
      <!-- Content ... -->
        <div class="field">
              <label class="label">Singkatan</label>
              <div class="control">
                <input class="input" type="text" placeholder="Singkatan" id="kata_singkatan">
              </div>
            </div>

            <div class="field">
              <label class="label">Arti Sebenarnya</label>
              <div class="control">
                <input class="input" type="text" id="makna_singkatan" placeholder="Arti Sebenarnya">
              </div>
            </div>

    </section>
    <footer class="modal-card-foot">
      <button class="button is-success" id="btn-ajukan">Ajukan</button>
      <button class="button btn-tutup-modal">Cancel</button>
    </footer>
  </div>
</div>

<div class="modal" id="modal-pesan-segmentasi-baris">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Segmentasi Baris</p>
      <button class="delete btn-tutup-modal" aria-label="close"></button>
    </header>
    <section class="modal-card-body">
      <!-- Content ... -->
      <p>Segmentasi Baris telah selesai</p>

    </section>
    <footer class="modal-card-foot">
    <a href="{{url('pengguna/segmentasi_baris')}}" class="button is-success">Lihat Hasil</a>
      <button class="button btn-tutup-modal is-danger">Tutup</button>
    </footer>
  </div>
</div>



<script type="text/javascript">

var tabel_pengajuan_singkatan;



function ajukan_singkatan() {
  // body...
  var kata_singkatan = $('#kata_singkatan').val();

  var makna_singkatan = $('#makna_singkatan').val();

   swal({
        title: "Pengajuan Singkatan Tidak Umum",
        text: "Apakah anda yakin ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ajukan",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;

        $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

        $.ajax({
            url: "/pengguna/singkatan/ajukan",
            type: "POST",
            data: {

             "kata_singkatan":kata_singkatan,
             "makna_singkatan":makna_singkatan
                  
            },
            dataType: "json",
            success: function (data) {
              
              if(data==1){

                swal("Done!", "Berhasil diajukan", "success");

                $('#modal-pengajuan-singkatan').removeClass('is-active');

                tabel_pengajuan_singkatan.ajax.reload();

              }

              else{

                swal("failed","Gagal melakukan pengajuan","error");

              }
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Failed!", "Gagal melakukan pengajuan", "error");

                console.log(thrownError);
            }
        });
    });
}

function batalkan_pengajuan(id_singkatan) {
  // body...
    swal({
        title: "Pembatalan Pengajuan Singkatan Tidak Umum",
        text: "Apakah anda yakin ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Batalkan",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;

        $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

        $.ajax({
            url: "{{url('pengguna/singkatan/batalkan_pengajuan')}}",
            type: "POST",
            data: {

             "id_singkatan":id_singkatan
                  
            },
            dataType: "json",
            success: function (data) {
              
              if(data==1){

                swal("Done!", "Berhasil dibatalkan", "success");

               
                tabel_pengajuan_singkatan.ajax.reload();

              }

              else{

                swal("failed","Gagal melakukan pembatalan","error");

              }
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Failed!", "Gagal melakukan pembatalan", "error");

                console.log(thrownError);
            }
        });
    });
}

function kirim_kritik_saran() {
  // body...
  var konten = $('#kritik_saran').val();

   swal({
        title: "Kirim Kritik dan Saran",
        text: "Apakah anda yakin ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Kirim",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;

        $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

        $.ajax({
            url: "{{url('pengguna/kritik_saran/kirim')}}",
            type: "POST",
            data: {

             "konten":konten
                  
            },
            dataType: "json",
            success: function (data) {
              
              if(data==1){

                swal("Done!", "Berhasil dikirim", "success");

               
                

              }

              else{

                swal("failed","Gagal melakukan pengiriman","error");

              }
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Failed!", "Gagal melakukan pengiriman", "error");

                console.log(thrownError);
            }
        });
    });

}

function convert_to_binary_image() {
  // body...

      $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

        $.ajax({
            url: "{{url('pengguna/pengenalan/convert_to_binary_image')}}",
            type: "POST",
            data: {

             
                  
            },
            dataType: "json",
            success: function (data) {
              
              if(data!="error"){
                
                toastr.success("Sukses","Berhasil diubah");

                var image_path = "{{asset('')}}"+"/"+data;

                 d = new Date();

                $("#binary_image").attr('src',image_path+"?"+d.getTime());

              }

              else{
                toastr.success("Gagal",data);
              }
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
                toastr.error("Gagal","Konversi gagal");
               

                console.log(thrownError);
            }
        });

}

function segment_line() {
  // body...
  $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

        $.ajax({
            url: "{{url('pengguna/pengenalan/segment_line')}}",
            type: "POST",
            data: {

             "jenis_segmentasi_baris":"fresh"
                  
            },
            dataType: "json",
            success: function (data) {
              
              if(data.constructor == Array){

                //toastr.success("Sukses","Segementasi Baris Berhasil");
                $('#modal-pesan-segmentasi-baris').addClass('is-active');

               

              }

              else{
                toastr.error("Gagal","Segmentasi Baris Gagal");
              }
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
                toastr.error("Gagal","Segmentasi Baris Gagal");
               

                console.log(thrownError);
            }
        });
}
    
    $(document).ready(function () {
        // body...
        $('#li-pengenalan').click(function () {
            // body...
            $('#li-pengenalan').addClass('active');

            $('#li-singkatan').removeClass('active');

            $('#li-kritik-saran').removeClass('active');

            $('.box-pengenalan').show();

            $('#box-singkatan').hide();

            $('#box-kritik-saran').hide();

        });

        $('#li-singkatan').click(function () {
            // body...
            $(this).addClass('active');

            $('#li-pengenalan').removeClass('active');

            $('#li-kritik-saran').removeClass('active');

            $("#box-singkatan").show();

            $('.box-pengenalan').hide();

            $('#box-kritik-saran').hide();

        });

        $('#li-kritik-saran').click(function () {
            // body...
            $(this).addClass('active');

            $('#li-singkatan').removeClass('active');

            $('#li-pengenalan').removeClass('active');

            $("#box-kritik-saran").show();

            $('#box-singkatan').hide();

            $('.box-pengenalan').hide();

        });

        $('.btn-tutup-modal').click(function () {
            // body...
            $('.modal').removeClass('is-active');
        });

        $('#btn-pengajuan-singkatan').click(function () {
            // body...
            $('#modal-pengajuan-singkatan').addClass('is-active');
        });

        $('#btn-ajukan').click(function () {
          // body...
          ajukan_singkatan();
        });

        tabel_pengajuan_singkatan = $('#tabel_pengajuan_singkatan').DataTable({
    
       "processing": true,
            "serverSide": true,
            "order": [],
            "columnDefs": [
    { "orderable": false, "targets": [0,4,5] }
  ] 
      ,
            "ajax":{
                     "url": "{{ url('pengguna/singkatan/daftar_pengajuan_singkatan') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{
                      _token: "{{csrf_token()}}",
                    
                  }
                   },
            "columns": [
                {data: 'no', name: 'no'},
                {data: 'kata_singkatan', name: 'kata_singkatan'},
                {data: 'makna_singkatan', name: 'makna_singkatan'},
                {data: 'tanggal_pengajuan', name: 'tanggal_pengajuan'},
                {data: 'status', name: 'status'},
                {data: 'actions', name: 'actions'},
               
            ]

    });

      

        $('#tabel_pengajuan_singkatan tbody').on('click','.btn-batalkan-pengajuan',function () {
          // body...
          var id_singkatan = $(this).data('idsingkatan');

          //alert(id_singkatan);
          batalkan_pengajuan(id_singkatan);
        });


        $('#btn-kirim-kritiksaran').click(function() {
            kirim_kritik_saran();
        });

        $('#btn-ubah-ke-binary').click(function () {
          // body...
          convert_to_binary_image();
        });

        $('#btn-segment-line').click(function () {
          // body...
          segment_line();
        });

          $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });


          $('#upload-sampel-gambar').fileupload({
            url: "{{url('pengguna/pengenalan/upload')}}",
            dataType: 'json',
            done: function (e, data) {

              var response = data._response;

              //console.log(response);

              //$("#original_image").attr('src',"");

              if(response.result.status == 200){

                // console.log(response.result);

                
                   toastr.success("Sukses","Upload Berhasil");
                

                
                
                var url_gambar = "{{asset('uploads/')}}"+"/"+response.result.data;

                d = new Date();

                $("#original_image").attr('src',url_gambar+"?"+d.getTime());

              }
              else{
                toastr.error("Gagal","Upload Gagal");
              }
              
            },
            progressall: function (e, data) {
                
                var progress = parseInt(data.loaded / data.total * 100, 10);
                
                $('#progress_upload_file').attr('value',progress);

               
            }
        });

        
    });
</script>
@endsection
