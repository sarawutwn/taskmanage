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
                            {{-- <th>Start date</th>
                            <th>Salary</th> --}}
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 px-0">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Project</h3>
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
                            {{-- <th>Start date</th>
                            <th>Salary</th> --}}
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
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
