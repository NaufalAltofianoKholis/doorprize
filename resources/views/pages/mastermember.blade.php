@extends('index')

@section('content')
<div class="container-fluid">    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Contact</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

 <!-- Input Form -->
<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Input Data Peserta</h6>
            </div>
            <div class="card-body">
                <form method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telp">Nomor Telepon</label>
                                <input type="text" class="form-control" id="telp" name="telp" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="member_code">Nomor Perserta</label>
                                <input type="text" class="form-control" id="member_code" name="member_code" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success row col-md-2 col-md-offset-5 mt-3 mb-3 mx-auto">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Table CRUD -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Contacts List</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Nomor Perserta</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i <= 5; $i++)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>Nama Contoh {{ $i }}</td>
                                <td>08123456789{{ $i }}</td>
                                <td>123456789{{ $i }}</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="#" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
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
