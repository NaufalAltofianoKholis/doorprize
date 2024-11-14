@extends('index')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gift Management</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Input Form -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Input Hadiah</h6>
                </div>
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="event_id">Jenis Event</label>
                            <select class="form-control" id="event_id" name="event_id" required>
                                <option value="" disabled selected>Pilih Jenis Event</option>
                                <option value="1">Event 1</option>
                                <option value="2">Event 2</option>
                                <option value="3">Event 3</option>  
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gift_name">Nama Hadiah</label>
                            <input type="text" class="form-control" id="gift_name" name="gift_name" required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
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
                    <h6 class="m-0 font-weight-bold text-primary">List </h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Event ID</th>
                                <th>Gift Name</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i <= 5; $i++)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $i }}</td>
                                <td>Gift Contoh {{ $i }}</td>
                                <td>{{ rand(1, 100) }}</td>
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
