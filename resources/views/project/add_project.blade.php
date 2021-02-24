@extends('layouts.master')

@section('content')

<div class="row">
<div class="col-lg-12 px-0">
    <div class="card shadow mb-4">
        <div class="card-header py-3 text-center">
            <h3 class="m-0 font-weight-bold text-primary">Project Name</h3>
        </div>
        <div class="card-body">
            <h4> Description. </h4>
        </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-lg-6 py-2">
    <div class="card shadow mb-4">
        <div class="card-header py-3 text-center">
            <h3 class="m-0 font-weight-bold text-primary">Case</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-6 py-2">
    <div class="card shadow mb-4">
        <div class="card-header py-3 text-center">
            <h3 class="m-0 font-weight-bold text-primary">Member</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>



    <script>
    </script>
@endsection

    <script>
        $(document).ready(function() {
            $.ajax({
                type: 'GET',
                url: 'api/project/get/all',
            });
        });
    </script>

</body>
</html>
