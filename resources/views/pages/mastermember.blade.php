@extends('index')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Member Management</h1>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Button to toggle form visibility -->
    <button id="toggleForm" class="btn btn-primary mb-3">Add Member</button>

    <!-- Input Form (Initially minimized) -->
    <div id="formContainer" style="display: none;">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Add or Edit Member
                        </h6>
                    </div>
                    <div class="card-body">
                        <form id="memberForm" method="POST" action="{{ route('members.store') }}">
                            @csrf
                                @if (isset($member))
                                @method('PUT')
                                @endif
                            <input type="hidden" id="memberId" name="id">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required  value="{{ old('name', $event->name ?? '') }}" >
                            </div>
                            {{-- <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div> --}}

                            <button type="submit" class="btn btn-success">{{ isset($member) ? 'Update Member' : 'Submit Member' }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Member List Table -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Member List</h6>
                </div>
                <div class="card-body">
                    @if ($members->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                {{-- <th>Email</th>
                                <th>Phone</th> --}}
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                            <tr>
                                <td>{{ $member->id }}</td>
                                <td>{{ $member->name }}</td>
                                {{-- <td>{{ $member->email }}</td>
                                <td>{{ $member->phone }}</td> --}}
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editMember({{ $member->id }})">Edit</button>
                                    <form method="POST" action="{{ route('members.destroy', $member->id) }}" class="d-inline" id="deleteForm_{{ $member->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $member->id }})">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>Member is Empty.</p>
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

        // Toggle form visibility
        toggleButton.addEventListener('click', function() {
            if (formContainer.style.display === 'none') {
                formContainer.style.display = 'block';
                toggleButton.textContent = 'Minimize';
            } else {
                formContainer.style.display = 'none';
                toggleButton.textContent = 'Add Member';
            }
        });

        // Edit member function to prefill form
        window.editMember = function(id) {
            fetch(`/mastermember/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('memberId').value = data.id;
                    document.getElementById('name').value = data.name;
                    // document.getElementById('email').value = data.email;
                    // document.getElementById('phone').value = data.phone;

                    // Change form action to the update route
                    document.querySelector('form').action = `/mastermember/${id}`;

                    // Show form if hidden
                    if (formContainer.style.display === 'none') {
                        formContainer.style.display = 'block';
                        toggleButton.textContent = 'Minimize';
                    }
                })
                .catch(error => console.error('Error:', error));
        };

        window.confirmDelete = function(memberId) {
            const confirmation = confirm("Are you sure you want to delete this member?");
            if (confirmation) {
                document.getElementById('deleteForm_' + memberId).submit();
            }
        };
    });
</script>
@endsection
