@extends('index')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gift Management</h1>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif



    <!-- Button to toggle form visibility -->
    <button id="toggleForm" class="btn btn-primary mb-3">Add Gift</button>

    <!-- Input Form (Initially minimized) -->
    <div id="formContainer" style="display: none;">
        <!-- Initially hidden -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            {{ isset($gift) ? 'Edit Gift' : 'Input Gift' }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ isset($gift) ? route('gifts.update', $gift->id) : route('gifts.store') }}" method="POST">
                            @csrf
                            @if (isset($gift))
                            @method('PUT')
                            @endif

                            <div class="form-group">
                                <label for="gift_name">Gift Name</label>
                                <input type="text" class="form-control" id="gift_name" name="name" value="{{ old('name', $gift->name ?? '') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="event_id">Event</label>
                                <select class="form-control" id="event_id" name="event_id" required>
                                    <option value="">Select an Event</option>
                                    @if(isset($events) && $events->isNotEmpty())
                                    @foreach ($events as $event)
                                    <option value="{{ $event->id }}" {{ old('event_id', $gift->event_id ?? '') ==
                                        $event->id ? 'selected' : '' }}>
                                        {{ $event->name }}
                                    </option>
                                    @endforeach
                                    @else
                                    <option>Event is empty</option>
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $gift->stock ?? '') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="is_main_doorprize">Is Main Doorprize</label>
                                <select class="form-control" id="is_main_doorprize" name="is_main_doorprize">
                                    <option value="0" {{ (old('is_main_doorprize', $gift->is_main_doorprize ?? 0) == 0)
                                        ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ (old('is_main_doorprize', $gift->is_main_doorprize ?? 0) == 1)
                                        ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success">{{ isset($gift) ? 'Update Gift' : 'Submit
                                Gift' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gift List Table -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Gift List</h6>
                </div>
                <div class="card-body">
                    @if(isset($gifts) && $gifts->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Gift Name</th>
                                <th>Event</th>
                                <th>Stock</th>
                                <th>Main Doorprize</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gifts as $gift)
                            <tr>
                                <td>{{ $gift->id }}</td>
                                <td>{{ $gift->name }}</td>
                                <td>{{ $gift->event->name }}</td>
                                <td>{{ $gift->stock }}</td>
                                <td>{{ $gift->is_main_doorprize ? 'Yes' : 'No' }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editGift({{ $gift->id }})">Edit</button>
                                    <form method="POST" action="{{ route('gifts.destroy', $gift->id) }}" class="d-inline" id="deleteForm_{{ $gift->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $gift->id }})">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>Gift is Empty.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Toggle Form Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const formContainer = document.getElementById('formContainer');
        const toggleButton = document.getElementById('toggleForm');

        // Minimize&Maximize form
        toggleButton.addEventListener('click', function() {
            formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
            toggleButton.textContent = formContainer.style.display === 'none' ? 'Add Gift' : 'Minimize';
        });

        // Function for prefill form :p
        window.editGift = function(id) {
            fetch(`/mastergift/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('gift_name').value = data.name;
                    document.getElementById('stock').value = data.stock;
                    document.getElementById('is_main_doorprize').value = data.is_main_doorprize;

                    document.querySelector('form').action = `/mastergift/${id}`;
                    if (formContainer.style.display === 'none') {
                        formContainer.style.display = 'block';
                        toggleButton.textContent = 'Minimize';
                    }
                })
                .catch(error => console.error('Error:', error));
        };

        // Function for deleting!
        window.confirmDelete = function(giftId) {
            if (confirm("Are you sure you want to delete this gift?")) {
                document.getElementById('deleteForm_' + giftId).submit();
            }
        };
    });

    // console.log(data);

</script>
@endsection
