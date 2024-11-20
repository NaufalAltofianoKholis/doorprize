@extends('nosidebar')

@section('content')
    <div class="container-fluid"
        style="background-image: url('{{ asset('assets/img/bg-lottery3.png') }}');
               background-size: cover;
               background-position: center;
               background-repeat: no-repeat;
               min-height: 100vh;">

        <div class="container py-5">
            <!-- Header -->
            <div class="page-header text-center mb-5">
                <h1 style="color: rgb(0, 0, 0); font-size: 50px; font-family: 'Poppins', sans-serif;"
                    class="font-weight-bold">
                    UNDIAN HADIAH
                </h1>
            </div>

            <!-- Form -->
            <form action="{{ route('giftresults.store') }}" method="POST" class="container">
                @csrf

                <!-- Dropdowns Section -->
                <div class="d-flex flex-wrap justify-content-center gap-4 mb-5">
                    <!-- Event Selection -->
                    <div class="form-group">
                        <label for="event-select" class="sr-only">Pilih Event</label>
                        <select id="event-select" name="event" class="form-control">
                            <option value="" selected disabled>Pilih Event</option>
                        </select>
                    </div>

                    <!-- Hadiah Selection -->
                    <div class="form-group">
                        <label for="hadiah-select" class="sr-only">Pilih Hadiah</label>
                        <select id="hadiah-select" name="hadiah" class="form-control">
                            <option value="" selected disabled>Pilih Hadiah</option>
                        </select>
                    </div>

                    <!-- Stock Display -->
                    <div class="form-group">
                        <label for="stock" class="sr-only">Stok</label>
                        <input id="stock" class="form-control bg-white" placeholder="Stok" readonly>
                    </div>
                </div>

                <!-- Display Box -->
                <div class="d-flex justify-content-center mb-5">
                    <div class="glass-box text-center p-4">
                        <h1 id="hadiah" class="font-weight-bold display-4" style="font-family: 'Coiny', cursive;">0000
                        </h1>
                    </div>
                </div>

                <!-- Hidden Input -->
                <input type="hidden" id="hadiah-value" name="hadiah_value" value="0000">

                <!-- Buttons -->
                <div class="d-flex justify-content-center gap-4">
                    <button id="acakBtn" type="button" class="btn btn-success font-weight-bold px-4">
                        Acak
                    </button>
                    <button id="berhentiBtn" type="button" class="btn btn-danger font-weight-bold px-4">
                        Berhenti
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .glass-box {
            width: 400px;
            color: #002029;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(7px);
            -webkit-backdrop-filter: blur(7px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>

    <!-- JavaScript -->
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Ambil CSRF token dari meta tag
                }
            });
            // Fetch available events
            $.ajax({
                method: "GET",
                url: "http://localhost:8000/getEvent",
                success: function(response) {
                    $("#event-select").append(
                        response.map(event => `<option value="${event.id}">${event.name}</option>`)
                    );
                },
                error: function(error) {
                    console.error("Error fetching events:", error);
                }
            });

            // Fetch available gifts when an event is selected
            $("#event-select").change(function() {
                const eventId = $(this).val();
                $("#hadiah-select").empty().append(
                    `<option value="" disabled selected>Loading...</option>`);

                $.ajax({
                    method: "GET",
                    url: `http://localhost:8000/getRegularGift/${eventId}`,
                    success: function(response) {
                        $("#hadiah-select").empty().append(
                            response.map(hadiah =>
                                `<option value="${hadiah.id}">${hadiah.name}</option>`)
                        );
                        $("#stock").val(response[0]?.stock || "0");
                    },
                    error: function(error) {
                        console.error("Error fetching gifts:", error);
                    }
                });
            });

            // Fetch stock when a gift is selected
            $("#hadiah-select").change(function() {
                let hadiahId = $("#hadiah-select").val();
                $("#stock").empty().append(
                    `<option value="" disabled selected>Loading...</option>`);
                $.ajax({
                    method: "GET",
                    url: "http://localhost:8000/getGiftStock/" + hadiahId,
                    success: function(response) {
                        console.log(response);
                        $("#stock").val(response[0]?.stock || "0");
                    }
                });
            });

            // Lottery logic
            let acakInterval;

            $("#acakBtn").click(function() {
                const selectedEvent = $("#event-select").val();
                const selectedHadiah = $("#hadiah-select").val();

                if (!selectedEvent || !selectedHadiah) {
                    alert("Silakan pilih event dan hadiah terlebih dahulu!");
                    return;
                }

                // Fetch member codes and start the lottery
                $.ajax({
                    method: "GET",
                    url: `http://localhost:8000/getMemberCodes/`,
                    success: function(response) {
                        const memberCodes = shuffleArray(response.map(member => member
                            .member_code));
                        startLottery(memberCodes);
                    },
                    error: function(error) {
                        console.error("Error fetching member codes:", error);
                    }
                });
            });

            $("#berhentiBtn").click(function() {
                clearInterval(acakInterval);
            });

            function startLottery(memberCodes) {
                let index = 0;

                acakInterval = setInterval(() => {
                    $("#hadiah").text(memberCodes[index]);
                    index = (index + 1) % memberCodes.length;
                }, 100);

                setTimeout(() => {
                    const selectedEvent = $("#event-select").val();
                    const selectedHadiah = $("#hadiah-select").val();
                    const winner = memberCodes[0];
                    $("#hadiah").text(winner);
                    $("#hadiah-value").val(winner);

                    clearInterval(acakInterval);

                    $.ajax({
                        type: "POST",
                        data: {
                            'event_id': selectedEvent,
                            'gift_id': selectedHadiah,
                            'member_code': winner,
                        },
                        url: "http://localhost:8000/mastergiftresult",
                        success: function(response) {

                            console.log("Data berhasil disimpan:", response);
                            console.log(selectedEvent, selectedHadiah, winner);
                        },
                        error: function(error) {
                            console.error("Error saving data:", error);
                        }
                    });

                }, 5000);
            }

            function shuffleArray(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
                return array;
            }
        });
    </script>
@endsection
