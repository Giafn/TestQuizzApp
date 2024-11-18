<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quizz-App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .allways-mobile-container {
            width: 100%;
            height: 100vh;
            position: relative;
            background-image: url('/bg.svg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        .fixed-bottom-in-container {
            position: absolute; /* Posisi relatif terhadap container */
            bottom: 0; /* Tempel di bawah container */
            width: 100%; 
            background-color: darkgray; /* Contoh warna latar elemen */
            text-align: center; /* Contoh untuk teks */
        }
        .content {
            /* height: calc(100% - 56px); */
            height: 100%;
            overflow-y: auto;
        }
        .navbar-light {
            /* rounded-top */
            border-radius: 1rem 1rem 0 0;
            /* shadow */
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .header-content {
            margin-bottom: 1rem;
        }
        .input-search {
            border-radius: 1.5rem 0 0 1.5rem !important;
        }
        .btn-search {
            border-radius: 0 1.5rem 1.5rem 0 !important;
        }
        /* Mengatur lebar scrollbar */
        ::-webkit-scrollbar {
            width: 3px; /* Untuk scrollbar vertikal */
            height: 3px; /* Untuk scrollbar horizontal */
        }

        /* Mengatur tampilan slider di scrollbar */
        ::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.5); /* Warna hitam dengan transparansi 70% */
            border-radius: 10px; /* Membuat sudutnya bulat (opsional) */
        }

        /* Mengatur track scrollbar */
        ::-webkit-scrollbar-track {
            background: transparent; /* Track scrollbar tetap transparan */
        }

        /* Mendukung browser lain (opsional) */
        body {
            scrollbar-width: 3px; /* Untuk Firefox: membuat scrollbar lebih tipis */
            scrollbar-color: rgba(0, 0, 0, 0.5) transparent; /* Warna thumb dan track */
        }

    </style>
</head>
<body>
    <div class="d-flex justify-content-center">
        <div class="allways-mobile-container shadow">
            @yield('content')
        </div>
    </div>
    <script>
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
        function setElementWidth() {
            const viewportHeight = window.innerHeight;
            const viewportWidth = window.innerWidth;
            const calculatedWidth = (viewportHeight * 9) / 16;
            
            // Pilih elemen yang ingin diubah
            const element = document.querySelector('.allways-mobile-container');
            
            if (element) {
                if (viewportWidth >= 992) {
                    element.style.width = `${calculatedWidth}px`;
                } else {
                    element.style.width = '100%';
                }
            }
        }
        
        // Panggil fungsi saat halaman dimuat
        window.addEventListener('load', setElementWidth);
        window.addEventListener('resize', setElementWidth);
        
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>
</html>