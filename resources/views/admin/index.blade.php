@extends('layouts.master')

@section('topbar')
    @include('layouts.topbar')
@endsection

@section('content')
<div class="col-lg-12 px-0">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Cases</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Create</th>
                        </tr>
                    </thead>
                    <thead id="caseShow">
                        {{-- case Show aria --}}
                    </thead>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <ul id="paginationCase" class="pagination justify-content-end">
                    {{-- paginate project aria --}}
                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="col-lg-12 px-0">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Projects</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Create Date</th>
                            <th>Code</th>
                        </tr>
                    </thead>
                    {{-- Project data form --}}
                    <thead id="projectShow">
                        {{-- project Show aria --}}
                    </thead>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <ul id="paginationProject" class="pagination justify-content-end">
                    {{-- paginate project aria --}}
                </ul>
            </nav>
        </div>
        
        {{-- <div class="text-align-center">
            <br>
            {!! $qr !!}
        </div> --}}
        
    </div>
</div>

<script>
    $(document).ready(function() {
        var token = $.cookie('token');
        var username = $.cookie('username');
        var role = $.cookie('role');
        if(token == null){
            $.removeCookie('token');
            $.removeCookie('username');
            $.removeCookie('role');
            window.history.back();
        }else {
            if(role != 'ADMIN'){
                $.removeCookie('token');
                $.removeCookie('username');
                $.removeCookie('role');
                window.history.back();
            }
        }
        
    });

    
</script>
@endsection
</body>
</html>
