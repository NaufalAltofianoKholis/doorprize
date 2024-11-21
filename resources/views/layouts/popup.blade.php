@section('popup')
<head>
    <link rel="stylesheet" href="{{ asset('assets/css/popup.css') }}">
</head>

<body>
    {{-- <button class="primary" onclick="showModalWithConfetti()">Open Dialog</button> --}}

    <dialog id="dialog">
        <canvas id="canvas"></canvas>
        <h2 class="message">SELAMAT NOMOR UNDIAN .......</h2>
        <h2 class="message" >MENDAPATKAN ....</h2>
        <button id="close-popup" onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
    </dialog>

    <script src="{{ asset('assets/js/popup.js') }}"></script>
</body>

@endsection
