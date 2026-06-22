<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pelanggan - AKA Rental</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; font-size: 1.05rem; }
        .user-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="user-bg min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden animate-fade-in">
        <div class="p-8 md:p-10">
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg mx-auto mb-4">
                    <i class="fas fa-user text-white text-3xl"></i>
                </div>
                <h1 class="text-3xl font-black text-gray-800 tracking-tighter uppercase">Login Pelanggan</h1>
                <p class="text-gray-500 mt-2 font-medium">Masuk untuk mulai sewa alat</p>
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

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="login" value="{{ old('login') }}" required autofocus
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all font-medium" 
                            placeholder="nama@email.com">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all font-medium" 
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <label for="remember_me" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-4 rounded-xl font-bold shadow-lg shadow-blue-200 uppercase tracking-widest hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                    Masuk <i class="fas fa-sign-in-alt ml-2"></i>
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:underline">Daftar Sekarang</a>
                </p>
                <div class="mt-4">
                    <a href="{{ route('landing') }}" class="text-xs font-bold text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-widest">
                        <i class="fas fa-chevron-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
