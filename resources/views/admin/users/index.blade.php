@extends('admin.layouts.master')

@section('title', 'User Management')
@section('page-title', 'Manage Users')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800">All Users</h3>
            <p class="text-sm text-slate-500">Manage system users and their permissions</p>
        </div>
        <div class="flex items-center space-x-2">
            <!-- Export Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="bg-white border border-slate-200 text-slate-700 px-4 py-2 rounded-xl hover:bg-slate-50 transition flex items-center">
                    <i class="fas fa-download mr-2"></i>Export
                    <i class="fas fa-chevron-down ml-2 text-xs"></i>
                </button>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 z-50 py-1">
                    <a href="{{ route('admin.users.export.excel', request()->query()) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                        <i class="fas fa-file-excel text-green-600 mr-2"></i>Export as Excel
                    </a>
                    <a href="{{ route('admin.users.export.csv', request()->query()) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                        <i class="fas fa-file-csv text-blue-600 mr-2"></i>Export as CSV
                    </a>
                    <a href="{{ route('admin.users.export.pdf', request()->query()) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                        <i class="fas fa-file-pdf text-red-600 mr-2"></i>Export as PDF
                    </a>
                </div>
            </div>
            
            <a href="{{ route('admin.users.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-xl hover:bg-indigo-700 transition flex items-center">
                <i class="fas fa-plus mr-2"></i>Add New User
            </a>
        </div>
    </div>
    
    <div class="p-6">
        <!-- Search and Filter -->
        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6 flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}"
                           class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <div>
                <select name="role" class="px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="status" class="px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition">
                Filter
            </button>
            
            @if(request()->has('search') || request()->has('role') || request()->has('status'))
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition">
                    <i class="fas fa-times mr-1"></i>Clear
                </a>
            @endif
        </form>
        
        <!-- Export Info Bar (shown when filters are applied) -->
        @if(request()->has('search') || request()->has('role') || request()->has('status'))
        <div class="mb-4 p-3 bg-indigo-50 rounded-xl flex items-center justify-between">
            <div class="flex items-center text-sm text-indigo-700">
                <i class="fas fa-filter mr-2"></i>
                <span>Filters applied. 
                    @if(request('search')) Search: "{{ request('search') }}" @endif
                    @if(request('role')) | Role: {{ ucfirst(request('role')) }} @endif
                    @if(request('status')) | Status: {{ ucfirst(request('status')) }} @endif
                </span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-xs text-indigo-500">Export filtered results:</span>
                <a href="{{ route('admin.users.export.excel', request()->query()) }}" class="text-indigo-600 hover:text-indigo-800" title="Export as Excel">
                    <i class="fas fa-file-excel"></i>
                </a>
                <a href="{{ route('admin.users.export.csv', request()->query()) }}" class="text-indigo-600 hover:text-indigo-800" title="Export as CSV">
                    <i class="fas fa-file-csv"></i>
                </a>
                <a href="{{ route('admin.users.export.pdf', request()->query()) }}" class="text-indigo-600 hover:text-indigo-800" title="Export as PDF">
                    <i class="fas fa-file-pdf"></i>
                </a>
            </div>
        </div>
        @endif
        
        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Last Login</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
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
                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="p-1 hover:bg-indigo-50 rounded-lg transition" title="View">
                                    <i class="fas fa-eye text-indigo-600"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="p-1 hover:bg-emerald-50 rounded-lg transition" title="Edit">
                                    <i class="fas fa-edit text-emerald-600"></i>
                                </a>
                                @if(!$user->hasRole('super-admin'))
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 hover:bg-red-50 rounded-lg transition" title="Delete">
                                        <i class="fas fa-trash text-red-600"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center">
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
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection