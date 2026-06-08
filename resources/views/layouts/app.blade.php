{{-- 
=================================================================
 FILE: layouts/app.blade.php
 FUNGSI: Template utama untuk semua halaman setelah login
         (Digunakan oleh Admin dan Pelanggan)
 FITUR: 
   - Top navbar dengan logo dan user info
   - Sidebar menu (berubah sesuai role)
   - Main content area
   - Responsive design
=================================================================
--}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AKA Rental')</title>
    
    {{-- Tailwind CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        
        /* Active sidebar menu */
        .sidebar-active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
        }
        
        /* Hover effect untuk card */
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        /* Animasi fade in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Scrollbar custom */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-gray-100">

    {{-- ==================== TOP NAVBAR ==================== --}}
    <nav class="bg-white shadow-lg sticky top-0 z-30">
        <div class="px-4 md:px-6 py-3 md:py-4">
            <div class="flex justify-between items-center">
                {{-- Logo dan Brand --}}
                <div class="flex items-center space-x-2 md:space-x-3">
                    <a href="/" class="flex items-center space-x-2">
                        <div>
                            <span class="text-lg md:text-xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">AKA Rental</span>
                            <p class="text-xs text-gray-500 hidden md:block">Sewa Kamera & Camping</p>
                        </div>
                    </a>
                </div>
                
                {{-- User Info & Logout --}}
                <div class="flex items-center gap-4">
                    <div class="hidden md:flex flex-col items-end mr-2">
                        <span class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] text-gray-500 uppercase tracking-widest font-black">{{ Auth::user()->role }}</span>
                    </div>

                    {{-- Tombol Logout (Laravel Breeze style) --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-3 md:px-4 py-1 md:py-2 rounded-lg hover:bg-red-600 transition text-sm md:text-base flex items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden md:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- ==================== MAIN CONTENT WITH SIDEBAR ==================== --}}
    <div class="flex flex-col md:flex-row min-h-[calc(100vh-70px)]">
        {{-- SIDEBAR KIRI (untuk desktop) --}}
        <aside class="w-full md:w-64 bg-white shadow-lg">
            <div class="p-4">
                {{-- Profile Summary Mobile --}}
                <div class="md:hidden flex items-center space-x-3 pb-4 mb-4 border-b border-gray-200">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 uppercase">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                
                {{-- Menu Sidebar --}}
                <ul class="space-y-2">
                    @yield('sidebar_menu')
                </ul>
            </div>
        </aside>

        {{-- MAIN CONTENT AREA --}}
        <main class="flex-1 p-4 md:p-6 fade-in">
            {{-- Alert Success --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm rounded-r-lg flex items-center justify-between">
                    <span><i class="fas fa-check-circle mr-2"></i> {{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">&times;</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        // Modal helpers
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
    </script>
</body>
</html>
