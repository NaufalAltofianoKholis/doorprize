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
                                <th>Event Name</th>
                                <th>Gift Name</th>
                                <th>Member Name</th> 
                                <th>Status Delivery</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($giftResults as $giftResult)
                            <tr>
                                <td>{{ $giftResult->event->name }}</td>
                                <td>{{ $giftResult->gift->name }}</td>
                                <td>{{ $giftResult->member->name }}</td>
                                <td>{{ $giftResult->status }}</td>    
                            </tr>
                            @endforeach
                            {{-- @foreach ($assignedGifts as $assignedGift)
                            <tr>
                                <td>{{ $assignedGift->event_name }}</td>
                                <td>{{ $assignedGift->gift_name }}</td>
                                <td>{{ $assignedGift->member_name }}</td>
                               
                                <td>{{ $assignedGift->status }}</td>
                            </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
