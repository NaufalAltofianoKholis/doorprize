@extends('nosidebar')
@section('lottery')

    <head>
        <link rel="stylesheet" href="{{ asset('assets/css/popup.css') }}">
    </head>

    <style>
        .glass-box {
            width: 400px;
            color: #002029;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(7px);
            border: 5px solid linear-gradient(to left, #743ad5, #d53a9d);
        }

        h1 {
            font-family: 'Coiny', cursive;
            font-size: 100px;

            /* background: -webkit-linear-gradient(-86deg, #EEF85B 5%, #7AEC8D 53%, #09E5C3 91%); */
            background: -webkit-linear-gradient(-86deg, #EEF85B 5%, #F68229 53%, #EEF85B 91%);
            -webkit-background-clip: text;
            -webkit-text-stroke: 4px transparent;
            color: #000000;
            letter-spacing: 80px;
        }

        select {
            border: 1px solid
        }

        .btn {
            background: #F68229;
            background: -webkit-linear-gradient(to right, #FFCF2D, #F68229);
            background: linear-gradient(to right, #FFCF2D, #F68229);
            color: white;
            border-radius: 30px;
            border: 3px solid white;
            letter-spacing: 2px;
        }

        .btn:hover {
            color: white;
        }
    </style>

    <dialog id="dialog">
        <canvas id="canvas"></canvas>
        <div class="message-container">
            <h2 class="message" id="title">SELAMAT🎉</h2>
            <div class="message-wrap">
                <div class="no-undian">
                    <h4 class="label-undian">Nomor Undian</h4>
                    <div class="kotak-undian">
                        <h2 class="message" id="winner-popup">0000</h2>
                    </div>
                </div>
                <div class="hadiah">
                    <h4 class="label-hadiah">Hadiah</h4>
                    <div class="kotak-hadiah">
                        <h2 class="message" id="prize-popup">Sepeda Listrik</h2>
                    </div>
                </div>      
            </div>
        </div>
        <button id="close-popup" onclick="window.dialog.close();" class="x">❌</button>
    </dialog>

    <div class="container-fluid"
        style="background-image: url('{{ asset('assets/img/bg-lottery3.png') }}');
               background-size: cover;
               background-position: center;
               background-repeat: no-repeat;
               min-height: 100vh;">

        <div class="container py-5">
            <!-- Header -->
            <div class="page-header text-center" style="margin-bottom: 260px;">
                {{-- <h1 style="color: rgb(0, 0, 0); font-size: 50px; font-family: 'Poppins', sans-serif;"
                    class="font-weight-bold">
                    UNDIAN HADIAH
                </h1> --}}
                <audio id="backsound" src="{{ asset('assets/audio/backsound_spin.mp3') }}"></audio>

            </div>

            <!-- Form -->
            <form action="{{ route('giftresults.store') }}" method="POST" class="container">
                @csrf

                <!-- Dropdowns Section -->
                <div class="d-flex flex-wrap justify-content-center col-md-6 mx-auto pt-3 mb-4 glass-box">
                    <!-- Event Selection -->
                    <div class="form-group mr-4">
                        {{-- <label for="event-select" class="sr-only">Pilih Event</label> --}}
                        <select id="event-select" name="event" class="form-control" style="cursor: pointer;">
                            <option value="" selected disabled>Event</option>
                        </select>
                    </div>

                    <!-- Hadiah Selection -->
                    <div class="form-group">
                        {{-- <label for="hadiah-select" class="sr-only">Pilih Hadiah</label> --}}
                        <select id="hadiah-select" name="hadiah" class="form-control" style="cursor: pointer;">
                            <option value="" selected disabled>Pilih Hadiah</option>
                        </select>
                    </div>

                    <!-- Stock Display -->
                    {{-- <div class="form-group">
                        <label for="stock" class="sr-only">Stok</label>
                        <input id="stock" class="form-control bg-white" placeholder="Stok" readonly>
                    </div> --}}
                </div>

                <!-- Display Box -->
                <div class="d-flex justify-content-center mb-4">
                    <div class="glass-box text-center pl-5 pt-3 " style="width: 600px">
                        <h1 id="hadiah" class="font-weight-bold">0000
                        </h1>
                    </div>
                </div>

                <!-- Hidden Input -->
                <input type="hidden" id="hadiah-value" name="hadiah_value" value="0000">

                <!-- Buttons -->
                <div class="d-flex justify-content-center gap-4">
                    <button id="acakBtn" type="button" class="btn btn-lg font-weight-bold px-5 btn">
                        ACAK
                    </button>
                    {{-- <button id="berhentiBtn" type="button" class="btn btn-danger font-weight-bold px-4">
                        Berhenti
                    </button> --}}
                </div>
            </form>
        </div>
    </div>



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
            
            // Select
            $("select").select2();

            // Fetch stock when a gift is selected
            $("#hadiah-select").change(function() {
                $("#hadiah").text("0000");
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
            const backsound = document.getElementById('backsound');

            $("#acakBtn").click(function() {
                const selectedEvent = $("#event-select").val();
                const selectedHadiah = $("#hadiah-select").val();

                if (!selectedEvent || !selectedHadiah) {
                    alert("Silakan pilih event dan hadiah terlebih dahulu!");
                    return;
                }

                // Mainkan backsound
                backsound.play();

                // Fetch member codes and start the lottery
                $.ajax({
                    method: "GET",
                    url: `http://localhost:8000/getMemberCodes/`,
                    success: function(response) {
                        console.log(response);

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
                // Hentikan backsound
                backsound.pause();
                backsound.currentTime = 0; // Reset audio ke awal
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
                    const selectedHadiahName = $("#hadiah-select option:selected").text();
                    const winner = memberCodes[0];
                    $("#hadiah").text(winner);
                    $("#hadiah-value").val(winner);

                    clearInterval(acakInterval);

                    // Hentikan backsound setelah pemenang dipilih
                    backsound.pause();
                    backsound.currentTime = 0;

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
                            $("#winner-popup").text(winner);
                            $("#prize-popup").text(selectedHadiahName );
                            showModalWithConfetti();
                        },
                        error: function(error) {
                            console.error("Error saving data:", error);
                        }
                    });
                }, 10000);
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
    <!-- Page level plugins -->
    <script src="{{ asset('assets/js/popup.js') }}"></script>
@endsection
