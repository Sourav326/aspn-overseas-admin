@extends('admin.layouts.master')

@section('title', 'Dashboard')
@section('page-title')
    Welcome back, {{ auth()->user()->name }}!
@endsection

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 mb-8 text-white shadow-xl">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold mb-2">Manpower Fulfillment Dashboard</h2>
            <p class="text-indigo-100 text-lg">Track and manage your recruitment activities in real-time</p>
            <div class="flex items-center space-x-4 mt-4">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar-alt text-indigo-200"></i>
                    <span>{{ now()->format('l, d F Y') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-clock text-indigo-200"></i>
                    <span>{{ now()->format('h:i A') }}</span>
                </div>
            </div>
        </div>
        <div class="mt-4 md:mt-0">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Dashboard" class="w-32 h-32 opacity-90">
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 stat-card">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-indigo-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-green-600 bg-green-50 px-3 py-1 rounded-full">
                <i class="fas fa-arrow-up mr-1"></i> {{ $userGrowth ?? 0 }}%
            </span>
        </div>
        <h3 class="text-3xl font-bold text-slate-800 mb-1">{{ number_format($totalUsers ?? 0) }}</h3>
        <p class="text-sm text-slate-500 mb-3">Total Users</p>
        <div class="flex items-center justify-between text-xs">
            <span class="text-slate-400">Target: 1,000</span>
            <span class="text-indigo-600 font-medium">{{ round(($totalUsers/1000)*100) }}%</span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
            <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ min(round(($totalUsers/1000)*100), 100) }}%"></div>
        </div>
    </div>
    
    <!-- Active Users Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 stat-card">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-check text-emerald-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                {{ $activePercentage ?? 0 }}% active
            </span>
        </div>
        <h3 class="text-3xl font-bold text-slate-800 mb-1">{{ number_format($activeUsers ?? 0) }}</h3>
        <p class="text-sm text-slate-500 mb-3">Active Users</p>
        <div class="flex items-center space-x-2">
            <div class="w-full bg-slate-100 rounded-full h-1.5">
                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $activePercentage }}%"></div>
            </div>
            <span class="text-xs text-slate-500">{{ $activePercentage }}%</span>
        </div>
    </div>
    
    <!-- New Today Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 stat-card">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-plus text-amber-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-amber-600 bg-amber-50 px-3 py-1 rounded-full">
                Last 24h
            </span>
        </div>
        <h3 class="text-3xl font-bold text-slate-800 mb-1">{{ number_format($newToday ?? 0) }}</h3>
        <p class="text-sm text-slate-500 mb-3">New Today</p>
        <div class="flex items-center space-x-2 text-xs">
            <span class="text-slate-400">vs yesterday:</span>
            <span class="text-green-600 font-medium">
                <i class="fas fa-arrow-up text-xs mr-1"></i>12%
            </span>
        </div>
    </div>
    
    <!-- Total Roles Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 stat-card">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-tag text-purple-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-purple-600 bg-purple-50 px-3 py-1 rounded-full">
                Roles
            </span>
        </div>
        <h3 class="text-3xl font-bold text-slate-800 mb-1">{{ number_format($totalRoles ?? 0) }}</h3>
        <p class="text-sm text-slate-500 mb-3">Active Roles</p>
        <div class="flex -space-x-2">
            @foreach(['Super Admin', 'Admin', 'Partner', 'Staff', 'User'] as $role)
                <div class="w-8 h-8 rounded-full bg-indigo-100 border-2 border-white flex items-center justify-center text-xs font-medium text-indigo-600 hover:z-10 transition-all" title="{{ $role }}">
                    {{ substr($role, 0, 1) }}
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Quick Stats Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Today's Overview -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Today's Overview</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-sign-in-alt text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-700">New Registrations</p>
                        <p class="text-xs text-slate-400">Last 24 hours</p>
                    </div>
                </div>
                <span class="text-2xl font-bold text-indigo-600">{{ $newToday ?? 0 }}</span>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-emerald-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-700">Verifications</p>
                        <p class="text-xs text-slate-400">Completed today</p>
                    </div>
                </div>
                <span class="text-2xl font-bold text-emerald-600">8</span>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-amber-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-700">Pending Tasks</p>
                        <p class="text-xs text-slate-400">Require attention</p>
                    </div>
                </div>
                <span class="text-2xl font-bold text-amber-600">20</span>
            </div>
        </div>
    </div>
    
    <!-- Role Distribution Summary -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-slate-800">Role Distribution</h3>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all</a>
        </div>
        <div class="space-y-4">
            @foreach($roleDistribution ?? [] as $role)
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full" style="background-color: {{ $role->color }}"></span>
                    <span class="text-sm text-slate-600">{{ $role->name }}</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-semibold text-slate-800">{{ $role->count }}</span>
                    <span class="text-xs text-slate-400 w-12">{{ round(($role->count / max($totalUsers, 1)) * 100) }}%</span>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5">
                <div class="rounded-full h-1.5" style="width: {{ round(($role->count / max($totalUsers, 1)) * 100) }}%; background-color: {{ $role->color }}"></div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-6 pt-4 border-t border-slate-100">
            <div class="flex items-center justify-between text-sm">
                <span class="text-slate-500">Total Users</span>
                <span class="font-bold text-slate-800">{{ number_format($totalUsers ?? 0) }}</span>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Quick Actions</h3>
        <div class="space-y-3">
            <a href="{{ route('admin.users.create') }}" class="block p-4 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition-all group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-indigo-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-plus text-indigo-700"></i>
                        </div>
                        <div>
                            <p class="font-medium text-indigo-900">Add New User</p>
                            <p class="text-xs text-indigo-600">Create a new user account</p>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right text-indigo-400 group-hover:translate-x-1 transition"></i>
                </div>
            </a>
            
            <a href="#" class="block p-4 bg-emerald-50 hover:bg-emerald-100 rounded-xl transition-all group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-emerald-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-export text-emerald-700"></i>
                        </div>
                        <div>
                            <p class="font-medium text-emerald-900">Export Reports</p>
                            <p class="text-xs text-emerald-600">Download user reports</p>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right text-emerald-400 group-hover:translate-x-1 transition"></i>
                </div>
            </a>
            
            <a href="#" class="block p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition-all group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-envelope text-purple-700"></i>
                        </div>
                        <div>
                            <p class="font-medium text-purple-900">Bulk Email</p>
                            <p class="text-xs text-purple-600">Send emails to users</p>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right text-purple-400 group-hover:translate-x-1 transition"></i>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Recent Users and System Status -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Recent Users Table -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Recent Users</h3>
                <p class="text-xs text-slate-500 mt-0.5">Latest registered users in the system</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium flex items-center">
                View All
                <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentUsers ?? [] as $user)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <span class="text-indigo-700 text-sm font-bold">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-slate-800">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ '@' . $user->username }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-600">{{ $user->email }}</p>
                            <p class="text-xs text-slate-400">{{ $user->phone }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @foreach($user->getRoleNames() as $role)
                                <span class="px-2 py-1 text-xs font-medium rounded-lg 
                                    @if($role == 'super-admin') bg-purple-50 text-purple-700
                                    @elseif($role == 'admin') bg-indigo-50 text-indigo-700
                                    @elseif($role == 'partner') bg-emerald-50 text-emerald-700
                                    @elseif($role == 'staff') bg-amber-50 text-amber-700
                                    @else bg-slate-50 text-slate-700
                                    @endif">
                                    {{ ucfirst($role) }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4">
                            @if($user->is_active)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700">
                                    Active
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-50 text-red-700">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $user->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-users text-4xl text-slate-300 mb-2"></i>
                                <p class="text-sm text-slate-500">No users found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Right Column - System Status & Pending Tasks -->
    <div class="space-y-6">
        <!-- System Status -->
        <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-white">System Status</h3>
                <span class="px-3 py-1 bg-white/20 rounded-full text-xs text-white">All Systems Operational</span>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between text-white">
                    <span class="text-indigo-100">Database</span>
                    <span class="flex items-center"><i class="fas fa-check-circle mr-2 text-emerald-300"></i> Connected</span>
                </div>
                <div class="flex items-center justify-between text-white">
                    <span class="text-indigo-100">Storage</span>
                    <span class="flex items-center">{{ $storageUsed ?? '45' }}% used</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-1.5">
                    <div class="bg-white h-1.5 rounded-full" style="width: {{ $storageUsed ?? 45 }}%"></div>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div>
                        <p class="text-indigo-200 text-xs">Last Backup</p>
                        <p class="text-white text-sm font-medium">2 hours ago</p>
                    </div>
                    <div>
                        <p class="text-indigo-200 text-xs">Server Load</p>
                        <p class="text-white text-sm font-medium">23%</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pending Tasks -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800">Pending Tasks</h3>
                <span class="px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-xs font-medium">20 total</span>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-amber-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">Verifications</p>
                            <p class="text-xs text-slate-400">Documents to verify</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-lg text-sm font-bold">12</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-envelope text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">Contact Forms</p>
                            <p class="text-xs text-slate-400">Awaiting response</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-bold">5</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-alt text-purple-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">New Demands</p>
                            <p class="text-xs text-slate-400">Open positions</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-lg text-sm font-bold">3</span>
                </div>
            </div>
            
            <a href="#" class="block text-center mt-4 text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                View all tasks <i class="fas fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>
        
        <!-- Quick Stats -->
        <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100">
            <h3 class="text-lg font-bold text-emerald-800 mb-3">Today's Stats</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-emerald-600 text-xs">Conversion Rate</p>
                    <p class="text-2xl font-bold text-emerald-800">23%</p>
                    <p class="text-xs text-emerald-600">↑ 5% from yesterday</p>
                </div>
                <div>
                    <p class="text-emerald-600 text-xs">Avg. Response</p>
                    <p class="text-2xl font-bold text-emerald-800">2.4h</p>
                    <p class="text-xs text-emerald-600">↓ 30min improvement</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Recent Activity</h3>
            <p class="text-sm text-slate-500">Latest activities across the system</p>
        </div>
        <a href="#" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">View All</a>
    </div>
    
    <div class="space-y-4">
        <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-0">
            <div class="flex items-center space-x-4">
                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-plus text-emerald-600 text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-800">New user registered</p>
                    <p class="text-xs text-slate-500">John Doe created an account</p>
                </div>
            </div>
            <span class="text-xs text-slate-400">5 min ago</span>
        </div>
        
        <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-0">
            <div class="flex items-center space-x-4">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-blue-600 text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-800">Candidate verified</p>
                    <p class="text-xs text-slate-500">Staff verified candidate #1234</p>
                </div>
            </div>
            <span class="text-xs text-slate-400">1 hour ago</span>
        </div>
        
        <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-0">
            <div class="flex items-center space-x-4">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-purple-600 text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-800">New demand created</p>
                    <p class="text-xs text-slate-500">Client created demand for 5 engineers</p>
                </div>
            </div>
            <span class="text-xs text-slate-400">2 hours ago</span>
        </div>
        
        <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-0">
            <div class="flex items-center space-x-4">
                <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-envelope text-amber-600 text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-800">Contact form submitted</p>
                    <p class="text-xs text-slate-500">New inquiry from website</p>
                </div>
            </div>
            <span class="text-xs text-slate-400">3 hours ago</span>
        </div>
    </div>
</div>
@endsection