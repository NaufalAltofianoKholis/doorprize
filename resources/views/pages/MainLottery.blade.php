@extends('index')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="page-header text-center">
                <h1 style="color: black;" class="font-weight-bold">HADIAH UTAMA</h1>
            </div>

            <div class="dropdown d-flex justify-content-center mt-3 mb-5">
                <button style="background-color:#cecece; color: black;" class="btn dropdown-toggle" type="button"
                    data-toggle="dropdown" aria-expanded="false">
                    Pilih Hadiah
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Hadiah 1</a>
                    <a class="dropdown-item" href="#">Hadiah 2</a>
                </div>
            </div>

            <div class="d-flex justify-content-center mb-5">
                <div style="color: black; width:400px;" class="border border-dark p-4 text-center">
                    <h1 id="hadiah" class="font-weight-bold">Hadiah 1</h1>
                </div>
            </div>

            <div class="d-flex justify-content-center mb-5">
                <div style="width: 200px; gap: 30px;" class="d-flex">
                    <button id="acakBtn" type="button" style="width: 100px; background-color:rgb(0, 145, 0); color: white"
                        class="btn font-weight-bold">Acak</button>
                    <button id="berhentiBtn" type="button" style="width: 100px; background-color:rgb(236, 0, 0); color: white"
                        class="btn font-weight-bold">Berhenti</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let acakInterval;
        let stopAcak;
        document.getElementById('acakBtn').addEventListener('click', function () {
            // Hentikan interval jika sudah berjalan
            clearInterval(acakInterval);
            clearTimeout(stopAcak);

            // Mulai interval baru untuk merandom angka
            acakInterval = setInterval(function () {
                let randomAngka = Math.ceil(Math.random() * 1499); // Random angka 0-9999
                document.getElementById('hadiah').textContent = randomAngka;
            }, 100); // Merandom setiap 100ms

            stopAcak = setTimeout(function() {
                clearInterval(acakInterval)
            }, 10000);
        });

        document.getElementById('berhentiBtn').addEventListener('click', function () {
            // Hentikan interval saat tombol berhenti ditekan
            clearInterval(acakInterval);
        });
    </script>
@endsection
