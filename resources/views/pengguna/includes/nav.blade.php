 <nav class="navbar has-shadow">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item" href="../">
          <img src="http://bulma.io/images/bulma-logo.png" alt="Bulma: a modern CSS framework based on Flexbox">
        </a>

                <div class="navbar-burger burger" data-target="navMenu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <div id="navMenu" class="navbar-menu">
                <div class="navbar-end">
                    <div class="navbar-item has-dropdown" id="meong">
                        <a class="navbar-link">
              Welcome, {{Auth::user()->name}}
            </a>

                        <div class="navbar-dropdown">
                
                
                      
                            <div class="navbar-item">
                                <a id="logout-pengguna">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</nav>

<script type="text/javascript">

function logout() {
    // body...
     $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

     $.ajax({
            url: "{{url('pengguna/logout')}}",
            type: "POST",
            data: {

                "name":"{{Auth::user()->name}}"
               
                        
            },
            dataType: "json",
            success: function (data) {
                
            
             location.href="{{url('pengguna/login')}}";

             //console.log(data);

             location.reload();
                
            }
            
        });
};
    
    $(document).ready(function () {
        // body...
        $('#logout-pengguna').click(function () {
            // body...
            logout();
        });

        $('#meong').click(function (e) {
            // body...
             e.stopPropagation();
            $('#meong').addClass('is-active');
        });


    });

    $(document).click(function () {
        // body...
        $('#meong').removeClass('is-active');
    });

</script>