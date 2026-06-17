<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AKA Rental - Sewa Kamera & Alat Camping</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { font-size: 1.05rem; }
        
        /* Background khusus untuk Hero Section (atas) */
        .hero-bg {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ asset('images/background_landing.jpg') }}') no-repeat center center;
            background-size: cover;
        }
        
        /* Background khusus untuk Kontak Section (bawah) */
        .kontak-bg {
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
        }
        
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in-up { animation: fadeInUp 0.8s ease-out; }
        html { scroll-behavior: smooth; }
        
        /* Toast notification style */
        .toast-laravel {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            animation: slideDown 0.3s ease-out;
        }
        @keyframes slideDown {
            from { transform: translateX(-50%) translateY(-100%); opacity: 0; }
            to { transform: translateX(-50%) translateY(0); opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-50">

    {{-- Error Handling (Laravel Style) --}}
    @if($errors->any())
        <div class="toast-laravel bg-red-600 text-white px-6 py-3 rounded-lg shadow-2xl flex items-center gap-3">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ $errors->first() }}</span>
            <button onclick="this.parentElement.remove()" class="font-bold">&times;</button>
        </div>
    @endif

    {{-- ==================== NAVBAR ==================== --}}
    <nav class="bg-white/90 backdrop-blur-md shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                {{-- Logo --}}
                <div class="flex items-center space-x-3">
                    <div>
                        <span class="text-2xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">AKA Rental</span>
                        <p class="text-xs text-gray-500">Sewa Kamera & Camping</p>
                    </div>
                </div>
                
                {{-- Menu Navigasi --}}
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#home" class="text-gray-700 hover:text-blue-600 transition font-medium">Beranda</a>
                    <a href="#keunggulan" class="text-gray-700 hover:text-blue-600 transition font-medium">Keunggulan</a>
                    <a href="#kontak" class="text-gray-700 hover:text-blue-600 transition font-medium">Hubungi Kami</a>
                </div>
                
                <button id="mobileMenuBtn" class="md:hidden text-2xl"><i class="fas fa-bars"></i></button>
            </div>
        </div>
    </nav>

    {{-- ==================== HERO SECTION ==================== --}}
    <section id="home" class="hero-bg text-white py-28 relative overflow-hidden">
        <div class="container mx-auto px-6 text-center relative z-10">
            <div class="max-w-4xl mx-auto fade-in-up">
                <div class="inline-block bg-white/20 backdrop-blur rounded-full px-4 py-1 mb-6">
                    <span class="text-sm font-semibold text-purple-300">Selamat Datang di AKA Rental!</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                    Sewa Kamera & 
                    <span class="text-yellow-300">Alat Camping</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 opacity-95">
                    Solusi lengkap untuk kebutuhan dokumentasi dan petualangan maupun liburanmu! 
                    <span class="inline-block animate-pulse">📸⛺</span>
                </p>

                <div class="flex flex-wrap justify-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                            class="bg-purple-600 text-white px-10 py-3 rounded-full font-bold hover:bg-purple-700 transition shadow-lg flex items-center gap-2">
                            <i class="fas fa-tachometer-alt"></i> Masuk ke Dashboard
                        </a>
                    @else
                        <button onclick="openModal('pelangganModal')" 
                            class="bg-blue-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-blue-700 transition shadow-lg flex items-center gap-2">
                            <i class="fas fa-user"></i> Login Pelanggan
                        </button>
                        <button onclick="openModal('registerModal')" 
                            class="bg-green-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-green-700 transition shadow-lg flex items-center gap-2">
                            <i class="fas fa-user-plus"></i> Daftar Sekarang
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== KEUNGGULAN KAMI ==================== --}}
    <section id="keunggulan" class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4 uppercase">KEUNGGULAN KAMI</h2>
                <p class="text-gray-500 max-w-2xl mx-auto font-medium">Kami menyediakan berbagai perlengkapan berkualitas tinggi untuk kebutuhan dokumentasi dan petualangan Anda</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card-hover bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-8 text-center shadow-md border border-blue-100/50">
                    <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-4xl">📸</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Kamera</h3>
                    <p class="text-gray-600">Kamera DSLR & Mirrorless dengan lensa lengkap dan kualitas tinggi untuk hasil memukau.</p>
                </div>
                <div class="card-hover bg-gradient-to-br from-green-50 to-teal-50 rounded-2xl p-8 text-center shadow-md border border-green-100/50">
                    <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-teal-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-4xl">⛺</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Alat Camping</h3>
                    <p class="text-gray-600">Tenda, sleeping bag, kompor portabel, dan aksesoris lainnya dengan kualitas terbaik.</p>
                </div>
                <div class="card-hover bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-8 text-center shadow-md border border-yellow-100/50">
                    <div class="w-20 h-20 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-4xl">🚀</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Harga Terjangkau</h3>
                    <p class="text-gray-600">Sewa barang impianmu dengan harga bersahabat dan proses yang sangat mudah.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== HUBUNGI KAMI ==================== --}}
    <section id="kontak" class="py-24 kontak-bg text-white relative overflow-hidden">
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">📞 Hubungi Kami</h2>
                <p class="text-xl opacity-95">Siap membantu Anda 24 jam sehari untuk petualangan yang tak terlupakan</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="bg-white/20 backdrop-blur rounded-2xl p-6 text-center hover:bg-white/30 transition border border-white/10">
                    <div class="w-16 h-16 bg-white/30 rounded-full flex items-center justify-center mx-auto mb-4"><i class="fas fa-phone-alt text-2xl"></i></div>
                    <h3 class="text-xl font-bold mb-2">Telepon</h3>
                    <p>+62 821 7024 4177</p>
                    <p class="text-sm opacity-80">Setiap Hari, 08.00 - 22.00</p>
                </div>
                <div class="bg-white/20 backdrop-blur rounded-2xl p-6 text-center hover:bg-white/30 transition border border-white/10">
                    <div class="w-16 h-16 bg-white/30 rounded-full flex items-center justify-center mx-auto mb-4"><i class="fas fa-envelope text-2xl"></i></div>
                    <h3 class="text-xl font-bold mb-2">Email</h3>
                    <p>akarental@gmail.com</p>
                    <p class="text-sm opacity-80">customer@akarental.com</p>
                </div>
                <div class="bg-white/20 backdrop-blur rounded-2xl p-6 text-center hover:bg-white/30 transition border border-white/10">
                    <div class="w-16 h-16 bg-white/30 rounded-full flex items-center justify-center mx-auto mb-4"><i class="fas fa-map-marker-alt text-2xl"></i></div>
                    <h3 class="text-xl font-bold mb-2">Lokasi</h3>
                    <p>Jl. Perkasa Blok 2 No.18</p>
                    <p class="text-sm opacity-80">Jodoh, Kota Batam</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== FOOTER ==================== --}}
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6 text-center">
            <p class="font-bold">&copy; 2026 AKA Rental - Sewa Kamera & Alat Camping.</p>
            <p class="text-gray-400 text-sm mt-2">Didesain dengan ❤️ untuk mempermudah hobi dokumentasi dan petualangan Anda.</p>
        </div>
    </footer>

    {{-- ==================== MODAL LOGIN PELANGGAN ==================== --}}
    <div id="pelangganModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-[60]">
        <div class="bg-white rounded-2xl p-8 w-96 max-w-[90%] shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-2"><i class="fas fa-user text-blue-600 text-2xl"></i><h2 class="text-2xl font-bold text-gray-800">Login Pelanggan</h2></div>
                <button onclick="closeModal('pelangganModal')" class="text-gray-400 text-2xl hover:text-gray-600">&times;</button>
            </div>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2 tracking-tight">EMAIL ANDA</label>
                    <input type="text" name="login" placeholder="masukan email anda" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2 tracking-tight">KATA SANDI</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-lg font-bold shadow-lg shadow-blue-200 uppercase tracking-widest">Masuk</button>
            </form>
            <p class="text-center text-gray-600 mt-6 text-sm font-medium">Belum punya akun? <button onclick="closeModal('pelangganModal'); openModal('registerModal');" class="text-blue-500 font-bold hover:underline">Daftar Sekarang</button></p>
        </div>
    </div>

    {{-- ==================== MODAL REGISTER ==================== --}}
    <div id="registerModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-[60]">
        <div class="bg-white rounded-2xl p-8 w-full max-w-md max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-2">
                    <i class="fas fa-user-plus text-green-600 text-2xl"></i>
                    <h2 class="text-2xl font-bold text-gray-800">Daftar Akun Baru</h2>
                </div>
                <button onclick="closeModal('registerModal')" class="text-gray-400 text-2xl hover:text-gray-600">&times;</button>
            </div>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" name="name" placeholder="Aldi Kepin" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500 outline-none transition-all" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Alamat Email</label>
                        <input type="email" name="email" placeholder="aldi@gmail.com" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500 outline-none transition-all" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kata Sandi</label>
                            <input type="password" name="password" placeholder="••••••••" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500 outline-none transition-all" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500 outline-none transition-all" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-full mt-8 bg-gradient-to-r from-green-500 to-green-600 text-white py-3.5 rounded-lg font-bold shadow-lg shadow-green-200 uppercase tracking-widest hover:opacity-90 transition">
                    Bergabung Sekarang
                </button>
            </form>
            
            <p class="text-center text-gray-600 mt-6 text-sm font-medium">
                Sudah punya akun? <button onclick="closeModal('registerModal'); openModal('pelangganModal');" class="text-blue-500 font-bold hover:underline">Login disini</button>
            </p>
        </div>
    </div>

    <script>
        // ==================== FUNGSI MODAL ====================
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
        
        window.onclick = function(event) { 
            if (event.target.classList.contains('fixed')) {
                closeModal(event.target.id);
            }
        }

        // Auto hide toast
        setTimeout(() => {
            const toast = document.querySelector('.toast-laravel');
            if(toast) toast.remove();
        }, 5000);
    </script>
</body>
</html>
