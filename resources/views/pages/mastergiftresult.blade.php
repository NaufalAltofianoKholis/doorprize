@extends('index')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Event Gifts Assignment</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Table CRUD -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Assigned Gifts to Events</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Event ID</th>
                                <th>Gift ID</th>
                                <th>Member ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i <= 5; $i++)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $i + 10 }}</td>
                                <td>{{ $i + 20 }}</td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
