@extends('index')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="page-header text-center">
                <h1 style="color: black;" class="font-weight-bold">HADIAH UTAMA</h1>
            </div>
            <form>
                <div style="gap: 30px;" class="container d-flex justify-content-center">
                    <div class="form-group d-flex justify-content-center mt-3 mb-5">
                        <label for="event-select" class="sr-only">Pilih Event</label>
                        <select id="event-select" class="form-control">
                            <option value="event1">Event 1</option>
                            <option value="event2">Event 2</option>
                        </select>
                    </div>
                    <div class="form-group d-flex justify-content-center mt-3 mb-5">
                        <label for="hadiah-select" class="sr-only">Pilih Hadiah</label>
                        <select id="hadiah-select" class="form-control">
                            <option value="hadiah1">Hadiah 1</option>
                            <option value="hadiah2">Hadiah 2</option>
                        </select>
                    </div>
                </div>
            </form>



            <div class="d-flex justify-content-center mb-5">
                <div style="color: black; width:400px;" class="border border-dark p-4 text-center">
                    <h1 id="hadiah" class="font-weight-bold">0000</h1>
                </div>
            </div>

            <div class="d-flex justify-content-center ">
                <div>
                    <div style="width: 200px; gap: 30px;" class="d-flex justify-content-center mb-3">
                        <button id="acakBtn" type="button"
                            style="width: 100px; background-color:rgb(0, 145, 0); color: white"
                            class="btn font-weight-bold">
                            Acak</button>
                        <button id="berhentiBtn" type="button"
                            style="width: 100px; background-color:rgb(236, 0, 0); color: white"
                            class="btn font-weight-bold">Berhenti</button>
                    </div>
                    <div class="ml-5">
                        <button id="simpanBtn" type="button"
                            style="width: 100px; background-color:rgb(0, 0, 236); color: white"
                            class="btn font-weight-bold ">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Menambahkan placeholder secara dinamis
        const eventSelect = document.getElementById('event-select');
        const hadiahSelect = document.getElementById('hadiah-select');
        const hadiahElem = document.getElementById('hadiah');

        // Placeholder text
        const placeholderTextEvent = "Pilih Event";
        const placeholderTextHadiah = "Pilih Hadiah";

        // Tambahkan placeholder ke dropdown event
        const placeholderOptionEvent = document.createElement("option");
        placeholderOptionEvent.textContent = placeholderTextEvent;
        placeholderOptionEvent.value = "";
        placeholderOptionEvent.hidden = true; // Menyembunyikan opsi di daftar
        placeholderOptionEvent.selected = true; // Menjadikannya opsi default
        eventSelect.prepend(placeholderOptionEvent);

        // Tambahkan placeholder ke dropdown hadiah
        const placeholderOptionHadiah = document.createElement("option");
        placeholderOptionHadiah.textContent = placeholderTextHadiah;
        placeholderOptionHadiah.value = "";
        placeholderOptionHadiah.hidden = true; // Menyembunyikan opsi di daftar
        placeholderOptionHadiah.selected = true; // Menjadikannya opsi default
        hadiahSelect.prepend(placeholderOptionHadiah);

        // Fungsi Acak dan Berhenti
        let acakInterval;
        let stopAcak;

        document.getElementById('acakBtn').addEventListener('click', function () {
            clearInterval(acakInterval);
            clearTimeout(stopAcak);

            acakInterval = setInterval(function () {
                let randomAngka = Math.ceil(Math.random() * 1499);
                hadiahElem.textContent = randomAngka;
            }, 100);

            stopAcak = setTimeout(function () {
                clearInterval(acakInterval);
            }, 10000);
        });

        document.getElementById('berhentiBtn').addEventListener('click', function () {
            clearInterval(acakInterval);
        });

        // Reset saat tombol Simpan ditekan
        document.getElementById('simpanBtn').addEventListener('click', function () {
            // Reset hadiah
            hadiahElem.textContent = "0000";

            // Reset dropdown ke placeholder
            eventSelect.value = "";
            hadiahSelect.value = "";

            console.log("Dropdown dan hadiah telah direset ke default.");
        });
    </script>
@endsection
