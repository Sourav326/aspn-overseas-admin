<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ASPN Overseas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .login-card {
            animation: fadeInUp 0.5s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="login-card bg-gray-800/50 backdrop-blur-sm p-8 rounded-2xl shadow-2xl w-96 border border-gray-400">
            <!-- Logo Section -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('assets/img/ASPN-logo.png') }}" alt="ASPN Overseas Logo" class="w-20 h-20 object-contain">
                </div>
                <h2 class="text-2xl font-bold text-white">ASPN Overseas</h2>
                <p class="text-gray-400 text-sm mt-1">Admin Panel Login</p>
                <div class="mt-3 flex justify-center">
                    <div class="h-px w-12 bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>
                </div>
            </div>

            @if($errors->any())
                <div class="bg-red-900/50 border border-red-700 text-red-200 px-4 py-3 rounded-xl mb-6 backdrop-blur-sm">
                    @foreach($errors->all() as $error)
                        <p class="text-sm flex items-center">
                            <i class="fas fa-exclamation-circle mr-2 text-red-400"></i>
                            {{ $error }}
                        </p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                
                <div class="mb-5">
                    <label for="email" class="block text-gray-300 text-sm font-semibold mb-2 flex items-center">
                        <i class="fas fa-envelope mr-2 text-blue-400 text-xs"></i>
                        Email Address
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"
                        placeholder="admin@aspnoverseas.com"
                        required autofocus>
                </div>

                <div class="mb-5">
                    <label for="password" class="block text-gray-300 text-sm font-semibold mb-2 flex items-center">
                        <i class="fas fa-lock mr-2 text-blue-400 text-xs"></i>
                        Password
                    </label>
                    <input type="password" name="password" id="password" 
                        class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-xl text-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"
                        placeholder="••••••••"
                        required>
                </div>

                <div class="mb-6 flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 focus:ring-2">
                        <span class="ml-2 text-sm text-gray-400">Remember Me</span>
                    </label>
                    <a href="{{route('password.request')}}" class="text-sm text-blue-400 hover:text-blue-300 transition">
                        Forgot Password?
                    </a>
                </div>

                <button type="submit" 
                    class="w-full gradient-bg text-white font-bold py-3 px-4 rounded-xl hover:shadow-lg transition-all duration-200 transform hover:scale-[1.02] flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Admin Login
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Secure Admin Access Only
                </p>
            </div>
        </div>
    </div>
</body>
</html>