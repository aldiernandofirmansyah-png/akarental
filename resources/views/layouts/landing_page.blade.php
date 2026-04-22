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
        
        /* Background khusus untuk Hero Section (atas) */
        .hero-bg {
            background: url('../images/background_landing.jpg') no-repeat center center;
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
        
        /* Toast notification style - di tengah atas */
        .toast-error {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #ef4444;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            z-index: 1000;
            animation: slideDown 0.3s ease-out;
        }
        .toast-success {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #22c55e;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
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
                <div class="hidden md:flex space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-blue-600 transition font-medium">Beranda</a>
                    <a href="#keunggulan" class="text-gray-700 hover:text-blue-600 transition font-medium">Keunggulan</a>
                    <a href="#kontak" class="text-gray-700 hover:text-blue-600 transition font-medium">Hubungi Kami</a>
                    <button onclick="openModal('adminModal')" 
                        class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition flex items-center gap-2">
                        <i class="fas fa-user-shield"></i> Login Admin
                    </button>
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
                {{-- LOGIN PELANGGAN & REGISTER DI TENGAH (HERO SECTION) --}}
                <div class="flex flex-wrap justify-center gap-4">
                    <button onclick="openModal('pelangganModal')" 
                        class="bg-blue-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-blue-700 transition shadow-lg flex items-center gap-2">
                        <i class="fas fa-user"></i> Login Pelanggan
                    </button>
                    <button onclick="openModal('registerModal')" 
                        class="bg-green-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-green-700 transition shadow-lg flex items-center gap-2">
                        <i class="fas fa-user-plus"></i> Daftar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== KEUNGGULAN KAMI ==================== --}}
    <section id="keunggulan" class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">KEUNGGULAN KAMI</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Kami menyediakan berbagai perlengkapan berkualitas tinggi untuk kebutuhan Anda</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card-hover bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-8 text-center shadow-md">
                    <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-4xl">📸</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Kamera</h3>
                    <p class="text-gray-600">Kamera DSLR dengan lensa lengkap dan kualitas tinggi, pokoknya keren dah</p>
                </div>
                <div class="card-hover bg-gradient-to-br from-green-50 to-teal-50 rounded-2xl p-8 text-center shadow-md">
                    <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-teal-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-4xl">⛺</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Alat Camping Lengkap</h3>
                    <p class="text-gray-600">Tenda, sleeping bag, kompor portabel, dan aksesoris lainnya dengan kualitas oke banget dah</p>
                </div>
                <div class="card-hover bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-8 text-center shadow-md">
                    <div class="w-20 h-20 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-4xl">🚀</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Harga Terjangkau</h3>
                    <p class="text-gray-600">Sewa barang disini dengan harga bersahabat sama dompet kamu dah</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== HUBUNGI KAMI ==================== --}}
    <section id="kontak" class="py-24 kontak-bg text-white relative overflow-hidden">
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">📞 Hubungi Kami</h2>
                <p class="text-xl opacity-95">Siap membantu Anda 24 jam sehari, 7 hari seminggu, 30 hari sebulan, 12 bulan setahun</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="bg-white/20 backdrop-blur rounded-2xl p-6 text-center hover:bg-white/30 transition">
                    <div class="w-16 h-16 bg-white/30 rounded-full flex items-center justify-center mx-auto mb-4"><i class="fas fa-phone-alt text-2xl"></i></div>
                    <h3 class="text-xl font-bold mb-2">Telepon</h3>
                    <p>+62 82170244177</p>
                    <p class="text-sm opacity-80">Senin-Minggu, 08.00-20.00</p>
                </div>
                <div class="bg-white/20 backdrop-blur rounded-2xl p-6 text-center hover:bg-white/30 transition">
                    <div class="w-16 h-16 bg-white/30 rounded-full flex items-center justify-center mx-auto mb-4"><i class="fas fa-envelope text-2xl"></i></div>
                    <h3 class="text-xl font-bold mb-2">Email</h3>
                    <p>akarental@gmail.com</p>
                    <p class="text-sm opacity-80">customer.service@akarental.com</p>
                </div>
                <div class="bg-white/20 backdrop-blur rounded-2xl p-6 text-center hover:bg-white/30 transition">
                    <div class="w-16 h-16 bg-white/30 rounded-full flex items-center justify-center mx-auto mb-4"><i class="fas fa-map-marker-alt text-2xl"></i></div>
                    <h3 class="text-xl font-bold mb-2">Alamat</h3>
                    <p>Jl. Perkasa Blok 2 No.18</p>
                    <p class="text-sm opacity-80">Jodoh dekat rumah Kepin </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== FOOTER ==================== --}}
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; 2026 AKA Rental - Sewa Kamera & Alat Camping.</p>
            <p class="text-gray-400 text-sm mt-2">Dibangun dengan ❤️ untuk memudahkan persewaan di sekitar batam</p>
        </div>
    </footer>

    {{-- ==================== MODAL LOGIN ADMIN ==================== --}}
    <div id="adminModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 w-96 max-w-[90%]">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-2"><i class="fas fa-user-shield text-purple-600 text-2xl"></i><h2 class="text-2xl font-bold">Login Admin</h2></div>
                <button onclick="closeModal('adminModal')" class="text-gray-400 text-2xl">&times;</button>
            </div>
            <form onsubmit="return loginAdmin(event)">
                @csrf
                <input type="hidden" name="role" value="admin">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Username</label>
                    <input type="text" id="adminUsername" placeholder="Masukkan username" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">Password</label>
                    <input type="password" id="adminPassword" placeholder="••••••••" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white py-2 rounded-lg font-semibold">Login</button>
            </form>
        </div>
    </div>

    {{-- ==================== MODAL LOGIN PELANGGAN ==================== --}}
    <div id="pelangganModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 w-96 max-w-[90%]">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-2"><i class="fas fa-user text-blue-600 text-2xl"></i><h2 class="text-2xl font-bold">Login Pelanggan</h2></div>
                <button onclick="closeModal('pelangganModal')" class="text-gray-400 text-2xl">&times;</button>
            </div>
            <form onsubmit="return loginPelanggan(event)">
                @csrf
                <input type="hidden" name="role" value="pelanggan">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" id="pelangganEmail" placeholder="Masukkan email" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">Password</label>
                    <input type="password" id="pelangganPassword" placeholder="••••••••" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-2 rounded-lg font-semibold">Login</button>
            </form>
            <p class="text-center text-gray-600 mt-4">Belum punya akun? <button onclick="closeModal('pelangganModal'); openModal('registerModal');" class="text-blue-500 font-semibold">Daftar</button></p>
        </div>
    </div>

    {{-- ==================== MODAL REGISTER ==================== --}}
    <div id="registerModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 w-full max-w-md max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-2">
                    <i class="fas fa-user-plus text-green-600 text-2xl"></i>
                    <h2 class="text-2xl font-bold">Daftar Akun Baru</h2>
                </div>
                <button onclick="closeModal('registerModal')" class="text-gray-400 text-2xl hover:text-gray-600">&times;</button>
            </div>
            
            <form onsubmit="return registerPelanggan(event)">
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" id="regNama" placeholder="Masukkan nama lengkap" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Email</label>
                        <input type="email" id="regEmail" placeholder="Masukkan email" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Password</label>
                        <input type="password" id="regPassword" placeholder="Masukkan password" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Konfirmasi Password</label>
                        <input type="password" id="regConfirmPassword" placeholder="Ketik ulang password" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500" required>
                    </div>
                </div>
                <button type="submit" class="w-full mt-6 bg-gradient-to-r from-green-500 to-green-600 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition">
                    Daftar Sekarang
                </button>
            </form>
            
            <p class="text-center text-gray-600 mt-4">
                Sudah punya akun? <button onclick="closeModal('registerModal'); openModal('pelangganModal');" class="text-blue-500 font-semibold">Login</button>
            </p>
        </div>
    </div>

    <script>
        // ==================== DATA LOGIN ====================
        // Data Admin (username & password)
        const adminCredentials = {
            username: "AdminKeren",
            password: "hahahaha4x"
        };
        
        // Data Pelanggan (email & password)
        let pelangganCredentials = [
            { email: "aldi@gmail.com", password: "aldi123", nama: "Aldi"},
            { email: "andi@gmail.com", password: "andi123", nama: "Andi"},
            { email: "kepin@gmail.com", password: "kepin123", nama: "Kepin"}
        ];
        
        // ==================== FUNGSI LOGIN ADMIN ====================
        function loginAdmin(event) {
            event.preventDefault();
            
            const username = document.getElementById('adminUsername').value;
            const password = document.getElementById('adminPassword').value;
            
            if (username === adminCredentials.username && password === adminCredentials.password) {
                showToast('Login Admin Berhasil! Selamat datang, ' + username, 'success');
                closeModal('adminModal');
                document.getElementById('adminUsername').value = '';
                document.getElementById('adminPassword').value = '';
                setTimeout(() => {
                    window.location.href = "/admin/dashboard";
                }, 1000);
            } else {
                showToast('Login Gagal! Username atau password salah.', 'error');
            }
        }
        
        // ==================== FUNGSI LOGIN PELANGGAN ====================
        function loginPelanggan(event) {
            event.preventDefault();
            
            const email = document.getElementById('pelangganEmail').value;
            const password = document.getElementById('pelangganPassword').value;
            
            const user = pelangganCredentials.find(user => user.email === email && user.password === password);
            
            if (user) {
                showToast('Login Pelanggan Berhasil! Selamat datang, ' + user.nama, 'success');
                closeModal('pelangganModal');
                document.getElementById('pelangganEmail').value = '';
                document.getElementById('pelangganPassword').value = '';
                setTimeout(() => {
                    window.location.href = "/pelanggan/dashboard";
                }, 1000);
            } else {
                showToast('Login Gagal! Email atau password salah.', 'error');
            }
        }
        
        // ==================== FUNGSI REGISTER ====================
        function registerPelanggan(event) {
            event.preventDefault();
            
            const nama = document.getElementById('regNama').value;
            const email = document.getElementById('regEmail').value;
            const password = document.getElementById('regPassword').value;
            const confirmPassword = document.getElementById('regConfirmPassword').value;
            
            // Validasi password match
            if (password !== confirmPassword) {
                showToast('Password dan Konfirmasi Password tidak sama!', 'error');
                return false;
            }
            
            // Validasi password minimal 6 karakter
            if (password.length < 6) {
                showToast('Password minimal 6 karakter!', 'error');
                return false;
            }
            
            // Cek apakah email sudah terdaftar
            const emailExists = pelangganCredentials.some(user => user.email === email);
            if (emailExists) {
                showToast('Email sudah terdaftar! Silakan login.', 'error');
                return false;
            }
            
            // Simpan data pelanggan baru
            pelangganCredentials.push({
                email: email,
                password: password,
                nama: nama
            });
            
            showToast('Registrasi Berhasil! Silakan login.', 'success');
            closeModal('registerModal');
            
            // Reset form register
            document.getElementById('regNama').value = '';
            document.getElementById('regEmail').value = '';
            document.getElementById('regPassword').value = '';
            document.getElementById('regConfirmPassword').value = '';
            
            // Buka modal login
            openModal('pelangganModal');
            
            return true;
        }
        
        // ==================== FUNGSI TOAST NOTIFICATION ====================
        function showToast(message, type) {
            const existingToast = document.querySelector('.toast-error, .toast-success');
            if (existingToast) {
                existingToast.remove();
            }
            
            const toast = document.createElement('div');
            toast.className = type === 'error' ? 'toast-error' : 'toast-success';
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
        
        // ==================== FUNGSI MODAL ====================
        function openModal(id) { 
            document.getElementById(id).classList.remove('hidden'); 
            document.getElementById(id).classList.add('flex'); 
        }
        
        function closeModal(id) { 
            document.getElementById(id).classList.add('hidden'); 
            document.getElementById(id).classList.remove('flex'); 
        }
        
        window.onclick = function(event) { 
            if (event.target.classList.contains('fixed')) {
                event.target.classList.add('hidden');
                event.target.classList.remove('flex');
            }
        }
    </script>
</body>
</html>