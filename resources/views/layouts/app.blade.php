<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
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
    </style>
</head>
<body>
    <div class="d-flex justify-content-center">
        <div class="allways-mobile-container shadow">
            <div class="content px-3 py-3">
                <div class="p-3 d-flex justify-content-between align-items-center mb-2">
                    <a href="/profile">
                        <img id="profileNavImg" src="https://api.dicebear.com/9.x/thumbs/svg?seed={{ auth()->user()->name }}" alt="Profile" class="rounded-pill w-100 border border-white" style="max-width: 50px">
                    </a>
                    <h4 href="/" class="text-white fw-bold">Quizz-App</h4>
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
                        <a href="/setting" class="nav-link {{ strpos(request()->path(), 'setting') === 0 ? 'text-primary' : ''}}">
                            <i class="bi bi-gear-fill p-5" style="font-size: 1.5em"></i>
                            <span class="d-block fw-bold">Setting</span>
                        </a>
                    </li>
                </ul>
            </nav>
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