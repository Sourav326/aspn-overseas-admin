<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ASPN Overseas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-gray-800 p-8 rounded-lg shadow-md w-96">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-white">ASPN Overseas</h2>
                <p class="text-gray-400">Admin Panel Login</p>
            </div>

            @if($errors->any())
                <div class="bg-red-900 border border-red-700 text-red-200 px-4 py-3 rounded mb-4">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                
                <div class="mb-4">
                    <label for="email" class="block text-gray-300 text-sm font-bold mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                        class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:border-blue-500"
                        required autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-300 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" id="password" 
                        class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:border-blue-500"
                        required>
                </div>

                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="mr-2">
                    <label for="remember" class="text-gray-300 text-sm">Remember Me</label>
                </div>

                <button type="submit" 
                    class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition">
                    Admin Login
                </button>
            </form>
        </div>
    </div>
</body>
</html>