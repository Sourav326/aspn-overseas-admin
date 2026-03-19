<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - ASPN Overseas</title>
    
    <!-- Tailwind CSS with modern configuration -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts - Inter for modern typography -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        /* Modern scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
        
        /* Animations */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Card hover effects */
        .stat-card {
            transition: all 0.2s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Gradient backgrounds */
        .gradient-primary {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        }
        
        .gradient-success {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }
        
        .gradient-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        }
        
        .gradient-danger {
            background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        }
        
        .gradient-info {
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-slate-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar - Modern dark design -->
        <aside class="w-72 bg-slate-900 text-white flex-shrink-0 hidden md:block overflow-y-auto">
            <div class="p-6">
                <!-- Logo -->
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 gradient-primary rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-briefcase text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight">ASPN Overseas</h1>
                        <p class="text-xs text-slate-400 mt-0.5">Manpower Fulfillment</p>
                    </div>
                </div>
                
                <!-- User Profile Card -->
                <div class="bg-slate-800/50 rounded-2xl p-4 mb-6 border border-slate-700/50">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 gradient-primary rounded-xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-slate-700">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400">Role</span>
                            <span class="px-2 py-1 bg-slate-700 rounded-lg text-white">
                                @foreach(auth()->user()->getRoleNames() as $role)
                                    {{ ucfirst($role) }}
                                @endforeach
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Menu -->
                <nav class="space-y-1">
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-4 mb-2">Main</div>
                    
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-gradient-primary text-white shadow-lg">
                        <i class="fas fa-chart-pie w-5"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">
                        <i class="fas fa-users w-5"></i>
                        <span class="font-medium">User Management</span>
                        <span class="ml-auto bg-blue-500/20 text-blue-400 text-xs px-2 py-1 rounded-full">New</span>
                    </a>
                    
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-4 mb-2 mt-6">Modules</div>
                    
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">
                        <i class="fas fa-user-tie w-5"></i>
                        <span class="font-medium">Candidates</span>
                        <span class="ml-auto bg-slate-800 text-slate-300 text-xs px-2 py-1 rounded-full">24</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">
                        <i class="fas fa-handshake w-5"></i>
                        <span class="font-medium">Partners</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">
                        <i class="fas fa-building w-5"></i>
                        <span class="font-medium">Clients</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">
                        <i class="fas fa-file-alt w-5"></i>
                        <span class="font-medium">Demands</span>
                        <span class="ml-auto bg-orange-500/20 text-orange-400 text-xs px-2 py-1 rounded-full">5</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">
                        <i class="fas fa-check-circle w-5"></i>
                        <span class="font-medium">Verifications</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">
                        <i class="fas fa-envelope w-5"></i>
                        <span class="font-medium">Contact Forms</span>
                        <span class="ml-auto bg-red-500/20 text-red-400 text-xs px-2 py-1 rounded-full">3</span>
                    </a>
                    
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-4 mb-2 mt-6">Settings</div>
                    
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">
                        <i class="fas fa-cog w-5"></i>
                        <span class="font-medium">Settings</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all duration-200">
                        <i class="fas fa-shield-alt w-5"></i>
                        <span class="font-medium">Roles & Permissions</span>
                    </a>
                    
                    <form method="POST" action="{{ route('admin.logout') }}" class="pt-4 mt-4 border-t border-slate-800">
                        @csrf
                        <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-red-500/10 hover:text-red-400 transition-all duration-200">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                </nav>
            </div>
        </aside>
        
        <!-- Mobile Menu Button -->
        <div class="md:hidden fixed top-0 left-0 right-0 bg-slate-900 text-white p-4 z-50">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 gradient-primary rounded-lg flex items-center justify-center">
                        <i class="fas fa-briefcase text-white text-sm"></i>
                    </div>
                    <span class="font-bold">ASPN Overseas</span>
                </div>
                <button id="mobileMenuBtn" class="p-2 hover:bg-slate-800 rounded-lg transition">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu Overlay -->
        <div id="mobileMenu" class="fixed inset-0 bg-slate-900 z-40 hidden md:hidden">
            <div class="p-6">
                <div class="flex justify-end mb-4">
                    <button id="closeMenuBtn" class="p-2 hover:bg-slate-800 rounded-lg transition">
                        <i class="fas fa-times text-xl text-white"></i>
                    </button>
                </div>
                <!-- Copy sidebar content here for mobile -->
            </div>
        </div>
        
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-slate-50">
            <!-- Top Navigation -->
            <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
                <div class="px-8 py-4 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-slate-800">@yield('page-title', 'Dashboard')</h1>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Search -->
                        <div class="relative hidden md:block">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="text" placeholder="Search..." 
                                   class="pl-10 pr-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-64">
                        </div>
                        
                        <!-- Notifications -->
                        <div class="relative">
                            <button class="p-2 hover:bg-slate-100 rounded-xl transition relative">
                                <i class="fas fa-bell text-slate-600 text-xl"></i>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                        </div>
                        
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 p-2 hover:bg-slate-100 rounded-xl transition">
                                <div class="w-8 h-8 gradient-primary rounded-lg flex items-center justify-center">
                                    <span class="text-white text-sm font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span class="text-sm font-medium text-slate-700 hidden md:block">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs text-slate-500"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content with fade-in animation -->
            <div class="p-8 fade-in">
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- Alpine.js for dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Mobile Menu Script -->
    <script>
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.remove('hidden');
        });
        
        document.getElementById('closeMenuBtn')?.addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.add('hidden');
        });
    </script>
    
    @stack('scripts')
</body>
</html>