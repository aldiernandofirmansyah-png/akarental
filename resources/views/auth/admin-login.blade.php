<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - AKA Rental</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; font-size: 1.05rem; }
        .admin-bg {
            background-image: url("{{ asset('images/latar.jpeg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="admin-bg min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden animate-fade-in">
        <div class="p-8 md:p-10">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-black text-gray-800 tracking-tighter">ADMIN AKARENTAL</h1>
                <p class="text-gray-500 mt-2 font-medium">Khusus Pengelola AKA Rental</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-r-xl">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="login" value="{{ old('login') }}" required autofocus
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 outline-none transition-all font-medium" 
                            placeholder="admin@akarental.com">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 outline-none transition-all font-medium" 
                            placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" 
                    class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-4 rounded-xl font-bold shadow-lg shadow-purple-200 uppercase tracking-widest hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                    Masuk Sekarang <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-gray-100 text-center">
                <a href="{{ route('landing') }}" class="text-sm font-bold text-purple-600 hover:text-purple-800 transition-colors">
                    <i class="fas fa-chevron-left mr-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html>
