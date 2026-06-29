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
    
    {{-- Tailwind CSS & Plugins --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    {{-- Vite Assets (Optional fallback) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { font-size: 1.05rem; }
        
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
    <nav class="bg-white shadow-md sticky top-0 z-40 h-16 md:h-20 flex items-center">
        <div class="container mx-auto px-4 md:px-8">
            <div class="flex justify-between items-center">
                {{-- Logo dan Brand --}}
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                            <i class="fas fa-camera-retro text-white"></i>
                        </div>
                        <div class="hidden sm:block">
                            <span class="text-xl font-black bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent tracking-tighter">AKA RENTAL</span>
                            <p class="text-[9px] text-gray-400 uppercase tracking-widest font-bold -mt-1">Peralatan Premium</p>
                        </div>
                    </a>
                </div>

                {{-- User Info & Logout --}}
                <div class="flex items-center gap-4">
                    <div class="hidden lg:flex flex-col items-end border-r pr-4 border-gray-100">
                        <span class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] text-purple-600 uppercase tracking-widest font-black">{{ Auth::user()->role }}</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-gray-50 text-gray-700 px-4 py-2 rounded-xl hover:bg-red-50 hover:text-red-600 transition-all duration-300 text-sm font-bold flex items-center gap-2 border border-gray-100">
                            <i class="fas fa-power-off text-xs"></i>
                            <span class="hidden sm:inline uppercase tracking-wider">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- ==================== MAIN CONTENT WITH SIDEBAR ==================== --}}
    <div class="flex flex-col md:flex-row min-h-screen">
        {{-- SIDEBAR KIRI (untuk desktop) --}}
        <aside class="w-full md:w-72 bg-white border-r border-gray-100 md:sticky md:top-20 z-20 h-auto md:h-[calc(100vh-80px)] overflow-y-auto">
            <div class="p-6">
                {{-- Profile Summary Mobile --}}
                <div class="md:hidden flex items-center space-x-4 p-4 bg-gray-50 rounded-2xl mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-md">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-purple-600 font-bold uppercase">{{ Auth::user()->role }}</p>
                    </div>
                </div>

                {{-- Menu Sidebar --}}
                <div class="mb-4 px-2 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Navigasi Utama</div>
                <ul class="space-y-2">
                    @if(Auth::user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition text-gray-700 font-medium {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : '' }}"><i class="fas fa-tachometer-alt mr-3"></i> Dashboard</a></li>
                        <li><a href="{{ route('admin.manajemen_barang') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition text-gray-700 font-medium {{ request()->routeIs('admin.manajemen_barang') ? 'sidebar-active' : '' }}"><i class="fas fa-boxes mr-3"></i> Manajemen Barang</a></li>
                        <li><a href="{{ route('admin.konfirmasi_booking') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition text-gray-700 font-medium {{ request()->routeIs('admin.konfirmasi_booking') ? 'sidebar-active' : '' }}"><i class="fas fa-calendar-check mr-3"></i> Konfirmasi Booking</a></li>
                        <li><a href="{{ route('admin.riwayat_sewa') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition text-gray-700 font-medium {{ request()->routeIs('admin.riwayat_sewa') ? 'sidebar-active' : '' }}"><i class="fas fa-history mr-3"></i> Riwayat Sewa</a></li>
                    @else
                        {{-- Menu Pelanggan --}}
                        <li>
                            <a href="{{ route('pelanggan.dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition text-gray-700 font-medium {{ request()->routeIs('pelanggan.dashboard') ? 'sidebar-active' : '' }}">
                                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pelanggan.riwayat_sewa') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-100 transition text-gray-700 font-medium {{ request()->routeIs('pelanggan.riwayat_sewa') ? 'sidebar-active' : '' }}">
                                <i class="fas fa-history mr-3"></i> Riwayat Sewa
                            </a>
                        </li>
                    @endif
                </ul>

                <div class="mt-10 pt-6 border-t border-gray-50">
                    <div class="px-4 py-4 bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl text-white">
                        <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Status Sistem</p>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-ping"></span>
                            <span class="text-xs font-bold">Server Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        {{-- MAIN CONTENT AREA --}}
        <main class="flex-1 bg-gray-50/50 p-4 md:p-10">
            <div class="max-w-7xl mx-auto">
                {{-- Alert Success --}}
                @if(session('success'))
                    <div class="mb-8 p-4 bg-white border border-emerald-100 shadow-sm rounded-2xl flex items-center justify-between fade-in">
                        <span class="flex items-center text-emerald-700 font-bold text-sm">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-check text-emerald-600 text-xs"></i>
                            </div>
                            {{ session('success') }}
                        </span>
                        <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600">&times;</button>
                    </div>
                @endif

                @yield('content')
            </div>
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
