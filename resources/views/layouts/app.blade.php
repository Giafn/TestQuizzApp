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
            min-height: 100vh;
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
            /* overflow-y: auto; */
        }
        .navbar-light {
            /* rounded-top */
            /* border-radius: 1rem 1rem 0 0; */
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
        #profileNavImg {
            border-width: 3px !important;
        }
        /* Mengatur lebar scrollbar */
        ::-webkit-scrollbar {
            width: 3px; /* Untuk scrollbar vertikal */
            height: 3px; /* Untuk scrollbar horizontal */
        }

        /* Mengatur tampilan slider di scrollbar */
        ::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.7); /* Warna hitam dengan transparansi 70% */
            border-radius: 10px; /* Membuat sudutnya bulat (opsional) */
        }

        /* Mengatur track scrollbar */
        ::-webkit-scrollbar-track {
            background: transparent; /* Track scrollbar tetap transparan */
        }

        /* Mendukung browser lain (opsional) */
        body {
            scrollbar-width: thin; /* Untuk Firefox: membuat scrollbar lebih tipis */
            scrollbar-color: rgba(0, 0, 0, 0.7) transparent; /* Warna thumb dan track */
        }

        .toast {
            bottom: 90px !important; /* Jarak dari bawah */
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="d-flex justify-content-center">
        <div class="allways-mobile-container shadow">
            <div class="content px-3 py-3">
                <div class="p-3 d-flex justify-content-between align-items-center mb-2">
                    <a href="/profile">
                        <img id="profileNavImg" src="https://api.dicebear.com/9.x/dylan/svg?seed={{ auth()->user()->name }}" alt="Profile" class="rounded-pill w-100 border border-white" style="max-width: 50px">
                    </a>
                    <h4 href="/" class="text-white fw-bold">Quizz-<span class="text-warning">App</span></h4>
                </div>
                <div class="header-content">
                    <h2 class="text-start">
                        <span class="text-white fw-bold">
                            @yield('title')
                        </span>
                    </h2>
                </div>
                <div class="body-content">
                    @yield('content')
                </div>
            </div>
            <nav class="navbar navbar-light bg-white navbar-expand sticky-bottom">
                <ul class="navbar-nav nav-justified w-100">
                    <li class="nav-item d-flex align-items-end">
                        <a href="/quizz" class="nav-link {{ strpos(request()->path(), 'quizz') === 0 ? 'text-primary' : ''}}">
                            <i class="bi bi bi-clipboard-fill" style="font-size: 1.5em"></i>
                            <span class="d-block fw-bold">Quizzes</span>
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-end">
                        <a href="/home" class="nav-link {{ strpos(request()->path(), 'home') === 0 ? 'text-primary' : ''}}">
                            <i class="bi bi-house-door-fill" style="font-size: 1.5em"></i>
                            <span class="d-block fw-bold">Home</span>
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-end">
                        <a href="/classes" class="nav-link {{ strpos(request()->path(), 'classes') === 0 ? 'text-primary' : ''}}">
                            <i class="bi bi-book-fill" style="font-size: 1.5em"></i>
                            <span class="d-block fw-bold">Classes</span>
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-end">
                        <a href="/saved" class="nav-link {{ strpos(request()->path(), 'saved') === 0 ? 'text-primary' : ''}}">
                            <i class="bi bi-bookmark-fill" style="font-size: 1.5em"></i>
                            <span class="d-block fw-bold">Saved</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        // document ready
        $(document).ready(function() {
            // show toast
            // toastr options
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-bottom-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            @if(session('success'))
                toastr.success("{{ session('success') }}")
            @endif
            @if(session('error'))
                toastr.error("{{ session('error') }}")
            @endif
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('scripts')
</body>
</html>