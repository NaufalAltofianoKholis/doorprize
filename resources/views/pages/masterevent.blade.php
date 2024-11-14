@extends('index')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Event Management</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Button to toggle form visibility -->
        <button id="toggleForm" class="btn btn-primary mb-3">Add Data</button>

        <!-- Input Form (Initially minimized) -->
        <div id="formContainer" style="display: none;"> <!-- Initially hidden -->
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                {{ isset($event) ? 'Edit Event' : 'Input Event' }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($event) ? route('events.update', $event->id) : route('events.store') }}"
                                method="POST">
                                @csrf
                                @if (isset($event))
                                    @method('PUT')
                                @endif

                                <div class="form-group">
                                    <label for="event_name">Event Name</label>
                                    <input type="text" class="form-control" id="event_name" name="name"
                                        value="{{ old('name', $event->name ?? '') }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_start">Date Start</label>
                                            <input type="date" class="form-control" id="date_start" name="date_start"
                                                value="{{ old('date_start', $event->date_start ?? '') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_end">Date End</label>
                                            <input type="date" class="form-control" id="date_end" name="date_end"
                                                value="{{ old('date_end', $event->date_end ?? '') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit"
                                    class="btn btn-success">{{ isset($event) ? 'Update Event' : 'Submit Event' }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Event List Table -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Event List</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Event Name</th>
                                    <th>Date Start</th>
                                    <th>Date End</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                    <tr>
                                        <td>{{ $event->id }}</td>
                                        <td>{{ $event->name }}</td>
                                        <td>{{ $event->date_start }}</td>
                                        <td>{{ $event->date_end }}</td>
                                        <td>
                                            <a id="editButton" class="btn btn-warning btn-sm"
                                                data-edit-id="{{ $event->id }}">Edit</a>
                                            <form method="POST" action="{{ route('events.destroy', $event->id) }}"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Toggle Form Script -->
    <script>
        $("document").ready(function() {

            const formContainer = $('#formContainer');

            $('#toggleForm').on('click', function() {
                if (formContainer.is(':hidden')) {
                    formContainer.show();
                    $(this).text('Minimize');
                } else {
                    formContainer.hide();
                    $(this).text('Add Data');
                }
            });

            $("#editButton").on('click', function() {

                const editId = $(this).data("edit-id");

                if (formContainer.is(":hidden")) {
                    formContainer.show();
                    $("#toggleForm").text("Minimize");
                window.location.href="http://localhost:8000/masterevent/?edit=11";
                }

            });
        })
    </script>
@endsection
