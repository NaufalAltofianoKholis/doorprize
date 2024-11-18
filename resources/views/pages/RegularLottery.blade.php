@extends('nosidebar')

@section('content')
<div class="container-fluid">
    <div class="container">
        <div class="page-header text-center">
            <h1 style="color: black;" class="font-weight-bold">UNDIAN HADIAH</h1>
        </div>

        <form action="{{ route('giftresults.store') }}" method="POST" class="container">
            @csrf
                <div style="gap: 30px;" class="d-flex justify-content-center">
                    <div class="form-group d-flex justify-content-center mt-3 mb-5">
                        <label for="event-select" class="sr-only">Pilih Event</label>
                        <select id="event-select" name="event" class="form-control">
                        </select>
                    </div>
                    <div class="form-group d-flex justify-content-center mt-3 mb-5">
                        <label for="hadiah-select" class="sr-only">Pilih Hadiah</label>
                        <select id="hadiah-select" name="hadiah" class="form-control">
                            <option selected>Pilih Hadiah</option>
                        </select>
                    </div>
                    <div class="form-group d-flex justify-content-center mt-3 mb-5">
                        <label for="stock" class="sr-only">Stok</label>
                        <input id="stock" class="form-control" style="background-color: white" placeholder="Stok" readonly>
                    </div>
                </div>

            <div class="d-flex justify-content-center mb-5">
                <div style="color: black; width:400px;" class="border border-dark p-4 text-center">
                    <h1 id="hadiah" class="font-weight-bold">0000</h1>
                </div>
            </div>

            <input type="hidden" id="hadiah-value" name="hadiah_value" value="0000">

            <div class="d-flex justify-content-center">
                <div>
                    <div style="width: 200px; gap: 30px;" class="d-flex justify-content-center mb-3">
                        <button id="acakBtn" type="button"
                            style="width: 100px; background-color:rgb(0, 145, 0); color: white"
                            class="btn font-weight-bold">Acak</button>
                        <button id="berhentiBtn" type="button"
                            style="width: 100px; background-color:rgb(236, 0, 0); color: white"
                            class="btn font-weight-bold">Berhenti</button>
                    </div>
                    {{-- <div class="ml-5">
                        <button id="simpanBtn" type="submit"
                            style="width: 100px; background-color:rgb(0, 0, 236); color: white"
                            class="btn font-weight-bold">Simpan</button>
                    </div> --}}
                </div>
            </div>
        </form>
    </div>
</div>


    <script>

        $(document).ready(function() {


            $.ajax({
                method: "GET",
                url: "http://localhost:8000/getEvent",
                success: function(response) {
                    console.log(response)

                    $("#event-select").empty();
                    $("#event-select").append("<option value='' id='selected'>Pilih Event</option>");

                    $.each(response, function(index, event) {
                        $("#event-select").append(
                            `<option value='${ event.id }' >${event.name}</option>`);
                    });

                },
                error: function(error) {
                    console.log(error);
                }
            });


            $("#event-select").change(function() {

                $("#selected").remove();

                $("#hadiah-select").empty();

                let eventId = $("#event-select").val();


                $.ajax({
                    method: "GET",
                    url: `http://localhost:8000/getRegularGift/${eventId}`,
                    success: function(response) {
                        console.log(response);
                        $.each(response, function(index, hadiah) {
                            $("#hadiah-select").append(
                                `<option value='${ hadiah.id }' >${hadiah.name}</option>`
                            );
                            $("#stock").val(response[0].stock);
                        });
                    }
                });
            })

            $("#hadiah-select").change(function () {

                let hadiahId = $("#hadiah-select").val();

              $.ajax({
                method: "GET",
                url: `http://localhost:8000/getGiftStock/${hadiahId}`,
                success: function (response) {

                    $("#stock").val(response[0].stock);
                    console.log(response);
                }
              });

            });

        });

        // Menambahkan placeholder secara dinamis
        const hadiahElem = document.getElementById('hadiah');

        let acakInterval;
        let stopAcak;
        document.getElementById('acakBtn').addEventListener('click', function() {
            // Ambil nilai dari dropdown event dan hadiah
            const selectedEvent = document.getElementById('event-select').value;
            const selectedHadiah = document.getElementById('hadiah-select').value;
            const hadiah= document.getElementById("hadiah").textContent;
            // const hadiahInput= document.getElementById("hadiah-input").value;

            // Validasi apakah event dan hadiah sudah dipilih
            if (!selectedEvent || !selectedHadiah) {
                alert("Silakan pilih event dan hadiah terlebih dahulu!");
                return; // Berhenti jika validasi gagal
            }

            // Hentikan interval jika sudah berjalan
            clearInterval(acakInterval);
            clearTimeout(stopAcak);

            // Mulai interval baru untuk merandom angka
            acakInterval = setInterval(function() {
                let randomAngka = Math.ceil(Math.random() * 1499); // Random angka 0-9999
                document.getElementById('hadiah').textContent = randomAngka;
            }, 100); // Merandom setiap 100ms

            stopAcak = setTimeout(function() {
                clearInterval(acakInterval);
                hadiahInput = hadiah;
                // console.log(hadia)
            }, 10000);
        });


        document.getElementById('berhentiBtn').addEventListener('click', function() {
            // Hentikan interval saat tombol berhenti ditekan
            clearInterval(acakInterval);
        });


        // Reset saat tombol Simpan ditekan
        document.getElementById('simpanBtn').addEventListener('click', function() {
            // Mencegah pengiriman form
            event.preventDefault();
            // Reset hadiah
            hadiahElem.textContent = "0000";

            // console.log("Dropdown dan hadiah telah direset ke default.");
        });
    </script>
@endsection
