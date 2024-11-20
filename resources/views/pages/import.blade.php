@extends('index')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Import Excel File</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Import Form -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Upload Excel File</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Select Excel File</label>
                            <input type="file" class="form-control-file" id="file" name="file" accept=".xlsx, .xls" required>
                        </div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructions or Upload History -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Import Instructions</h6>
                </div>
                <div class="card-body">
                    <p>Please upload an Excel file with the correct format. Accepted formats: .xlsx, .xls</p>
                    <p>Ensure your file contains the following columns:</p>
                    <ul>
                        <li><strong>Column A:</strong> Name</li>
                        <li><strong>Column B:</strong> Phone</li>
                        <li><strong>Column C:</strong> Event ID (if necessary)</li>
                    </ul>
                    <!-- Optionally, you can include a list or a log of past uploads here -->
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
