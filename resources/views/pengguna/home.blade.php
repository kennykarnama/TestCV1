@extends('pengguna.layout.general')

@section('content')
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
           
           
               <div class="box" id="box-pengenalan">
                   <p>Ini Pengenalan</p>
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
                    </tr>
                </thead>

                <tbody></tbody>
            </table>

             </div>
  
               
          

           <div class="box" id="box-kritik-saran" style="display: none;">

           <div class="field">
              <div class="control">
                <textarea class="textarea is-primary" type="text" placeholder="Kritik dan Saran"></textarea>
              </div>
            </div>

            <a class="button">
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
                <input class="input" type="text" placeholder="Singkatan" id="singkatan">
              </div>
            </div>

            <div class="field">
              <label class="label">Arti Sebenarnya</label>
              <div class="control">
                <input class="input" type="text" id="arti-sebenarnya" placeholder="Arti Sebenarnya">
              </div>
            </div>

    </section>
    <footer class="modal-card-foot">
      <button class="button is-success" id="btn-ajukan">Ajukan</button>
      <button class="button btn-tutup-modal">Cancel</button>
    </footer>
  </div>
</div>



<script type="text/javascript">
    
    $(document).ready(function () {
        // body...
        $('#li-pengenalan').click(function () {
            // body...
            $('#li-pengenalan').addClass('active');

            $('#li-singkatan').removeClass('active');

            $('#li-kritik-saran').removeClass('active');

            $('#box-pengenalan').show();

            $('#box-singkatan').hide();

            $('#box-kritik-saran').hide();

        });

        $('#li-singkatan').click(function () {
            // body...
            $(this).addClass('active');

            $('#li-pengenalan').removeClass('active');

            $('#li-kritik-saran').removeClass('active');

            $("#box-singkatan").show();

            $('#box-pengenalan').hide();

            $('#box-kritik-saran').hide();

        });

        $('#li-kritik-saran').click(function () {
            // body...
            $(this).addClass('active');

            $('#li-singkatan').removeClass('active');

            $('#li-pengenalan').removeClass('active');

            $("#box-kritik-saran").show();

            $('#box-singkatan').hide();

            $('#box-pengenalan').hide();

        });

        $('.btn-tutup-modal').click(function () {
            // body...
            $('.modal').removeClass('is-active');
        });

        $('#btn-pengajuan-singkatan').click(function () {
            // body...
            $('#modal-pengajuan-singkatan').addClass('is-active');
        });
    });
</script>
@endsection
