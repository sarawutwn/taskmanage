<!-- Content Row -->
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-12 col-sm-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            <div style="font-size: 16;">
                                Newest Case
                            </div>

                            <div id="newest" style="font-size: 40; text-align: right;"></div>
                        </div>
                        {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div> --}}
                    </div>
                    {{-- <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-12 col-sm-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            <div style="font-size: 16;">
                                Finished cases
                            </div>

                            <div id="finished" style="font-size: 40; text-align: right;"></div>
                        </div>
                        {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div> --}}
                    </div>
                    {{-- <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    {{-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Pending Requests Card Example -->
    <div class="col-12 col-sm-4 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            <div style="font-size: 16;">
                                inprocess cases
                            </div>

                            <div id="inprocess" style="font-size: 40; text-align: right;"></div>
                        </div>
                        {{-- <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending Requests</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">18</div> --}}
                    </div>
                    {{-- <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('themes/js/sb-admin-2.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="{{ asset('themes/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var token = $.cookie('token');
        if(token == null){
            window.location = 'login';
        }
        $.ajax({
            type: 'GET',
            url: 'api/project/member/case/getStatusCount',
            dataType: 'json',
            headers: {
                'Authorization': 'Bearer '+token,
            },
            success: function(data) {
                $('#newest').append(data.new);
                $('#finished').append(data.success);
                $('#inprocess').append(data.open);
            },
        });

    });
</script>
