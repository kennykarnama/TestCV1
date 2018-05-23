@extends('pengguna.layout.auth')

@section('content')



<div class="container">


<div class="pageloader is-right-to-left" id="page-loader">
<span class="title">
<p style="text-align: center;">Registrasi Sukses</p>
<p style="text-align: center;"><a href="{{url('pengguna/login')}}">Kembali Ke Halaman Login</a></p>
</span>
</div>

<section class="hero is-primary">
  <div class="hero-body">
    <div class="container">
      <h1 class="title">
       Register As User
      </h1>
      <h2 class="subtitle">
         <a class="button" href="{{url('pengguna/login')}}">
            <span class="icon">
              <i class="fa fa-backward"></i>
            </span>
            <span>Back</span>
          </a>
      </h2>
    </div>
  </div>
</section>

<div class="columns">
    <div class="column"></div>
    <div class="column">
    <div class="box">

    <div class="field">
      <label class="label">Username</label>
      <div class="control">
        <input class="input" type="text" name="username" id="username" placeholder="Username">
      </div>
    </div>

    <div class="field">
      <label class="label">Email</label>
      <div class="control">
        <input class="input" type="email" name="email" id="email" placeholder="Email">
      </div>
       <p class="help" id="keterangan_email"></p>
    </div>

    <div class="field">
      <label class="label">Password</label>
      <div class="control">
        <input class="input" type="password" name="password" id="password" placeholder="Password">
      </div>
    </div>

    <div class="field">
      <label class="label">Confirm Password</label>
      <div class="control">
        <input class="input" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
      </div>
      <p class="help" id="keterangan_confirm_password"></p>
    </div>

    <div class="columns">
        <div class="column"></div>
        <div class="column">
            <div class="field is-grouped">
      <p class="control">
        <a class="button is-link" id="btn-register-user">
          Register
        </a>
      </p>
      
    </div>
    
        </div>
        <div class="column"></div>
    </div>

    

    </div>     
    </div>
    <div class="column"></div>
   
</div>



 

</div>

<script type="text/javascript">

function match_password() {
    // body...
    var password = $('#password').val();

    var confirm_password = $('#confirm_password').val();

    if(password == ""){
         $('#keterangan_confirm_password').text("");
        $('#confirm_password').removeClass('is-danger');
        $('#confirm_password').removeClass('is-success');
    }

    else{

         if(password!=confirm_password){
        $('#keterangan_confirm_password').text("Password doesn't match");
        $('#confirm_password').addClass('is-danger');
        $('#confirm_password').removeClass('is-success');
    }

    else{
        $('#keterangan_confirm_password').text("Password cocok");
        $('#confirm_password').addClass('is-success');
        $('#confirm_password').removeClass('is-danger');
    }

    }

   

}

function check_email() {
    // body...
    var email = $('#email').val();

    if(email == ""){
          $('#keterangan_email').text("");
          $('#keterangan_email').removeClass('is-danger');
          $('#keterangan_email').removeClass('is-success');
    }

    else{

           $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

        $.ajax({
            url: "{{url('pengguna/register/check_email')}}",
            type: "POST",
            data: {

                "email":email
                        
            },
            dataType: "json",
            success: function (data) {
                

               if(data==1){
                    $('#keterangan_email').text("Email sudah terdaftar");
                    $('#keterangan_email').addClass('is-danger');
               }

               else{
                    $('#keterangan_email').text("Email bisa digunakan");
                    $('#keterangan_email').addClass('is-success');
               }
                
            }
            
        });

    }

  
}

function register_user() {
    // body...
    var username = $('#username').val();

    var password = $('#password').val();

    var email = $('#email').val();

    //alert(username+" "+password+" "+email);

     $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

     $.ajax({
            url: "{{url('pengguna/register')}}",
            type: "POST",
            data: {

                "username":username,
                "email":email,
                "password":password
                        
            },
            dataType: "json",
            success: function (data) {
                

              if(data == 1){
                $('#page-loader span .title').html("Registrasi Berhasil");

                $('#page-loader').addClass('is-active');
              
              }

              else{
                toastr.error('Harap Mengulangi proses registrasi', 'Registrasi Gagal!');
              }
                
            }
            
        });

}
    
    $(document).ready(function () {
        // body...
        $('#confirm_password').on('keyup',match_password);

        $('#email').on('keyup',check_email);

        $('#btn-register-user').click(function () {
            // body...
            register_user();
        });
    });

</script>
@endsection
