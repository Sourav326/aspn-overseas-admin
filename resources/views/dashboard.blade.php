<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ASPN Overseas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <span class="text-xl font-semibold">ASPN Overseas</span>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Welcome, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">User Dashboard</h1>
        
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-700">Welcome to your dashboard. This is a regular user view.</p>
            <p class="text-gray-600 mt-2">Email: {{ auth()->user()->email }}</p>
            <p class="text-gray-600">Phone: {{ auth()->user()->phone }}</p>
            <p class="text-gray-600">Last Login: {{ auth()->user()->last_login_at ?? 'Never' }}</p>
        </div>
    </div>
</body>
</html>