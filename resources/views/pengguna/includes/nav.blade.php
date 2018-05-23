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
                    <div class="navbar-item has-dropdown is-active">
                        <a class="navbar-link">
              Account
            </a>

                        <div class="navbar-dropdown">
                            <a class="navbar-item">
                Dashboard
              </a>
                            <a class="navbar-item">
                Profile
              </a>
                            <a class="navbar-item">
                Settings
              </a>
                            <hr class="navbar-divider">
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

               
                        
            },
            dataType: "json",
            success: function (data) {
                
            
             location.href="{{url('pengguna/login')}}";

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
    });

</script>