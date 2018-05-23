@extends('pengguna.layout.auth')

@section('content')
 <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-grey">Login</h3>
                    <p class="subtitle has-text-grey">Please login to proceed.</p>
                    <div class="box">
                        <figure class="avatar">
                            <img src="https://placehold.it/128x128">
                        </figure>
                       
                            <div class="field">
                                <div class="control">
                                    <input class="input is-large" name="email" id="email" type="email" placeholder="Your Email" autofocus="">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input class="input is-large" type="password" name="password" id="password" placeholder="Your Password">
                                </div>
                            </div>
                            <div class="field">
                                <label class="checkbox">
                  <input type="checkbox" name="remember" id="remember">
                  Remember me
                </label>
                            </div>
                            <button class="button is-block is-info is-large is-fullwidth" id="btn-login">Login</button>
                        
                    </div>
                    <p class="has-text-grey">
                        <a href="{{url('pengguna/register')}}">Sign Up</a> &nbsp;·&nbsp;
                        <a href="../">Forgot Password</a> &nbsp;·&nbsp;
                        <a href="../">Need Help?</a>
                    </p>
                </div>
            </div>
        </div>
</section>

<script type="text/javascript">

function signin() {
    // body...
    var email = $('#email').val();

    var password = $('#password').val();

     $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

     $.ajax({
            url: "{{url('pengguna/login')}}",
            type: "POST",
            data: {

                "email":email,
                "password":password
                        
            },
            dataType: "json",
            success: function (data) {
                

              if(data == 0){
                toastr.error('Username atau password salah', 'Login Gagal!');
              }

              else{
                location.href = "{{url('pengguna/home')}}";

                location.reload();
              }
                
            }
            
        });
    
}
    $(document).ready(function () {
        // body...
        $('#btn-login').click(function () {
            // body...
            signin();
        });
    });
</script>
@endsection
