<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="a_onLogout" class="btn btn-primary" href="#">Logout</a>
            </div>
        </div>
    </div>
</div>
<script>
    $('#a_onLogout').click(function(e) {
        e.preventDefault();
        var token = $.cookie('token');
        if (token == null) {
            return window.location = 'login';
        }
        // logout
        $.ajax({
            type: "POST",
            url: "/api/logout",
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function(response) {
                // if (response.status == 200) {
                    $.removeCookie('token');
                    $.removeCookie('username');
                    $.removeCookie('name');
                    $.removeCookie('role');
                    $.removeCookie('caseData');
                    window.location = '/login';
                // }
            }
        });
    });

</script>
