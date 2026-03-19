@extends('admin.layouts.master')

@section('title', 'User Details')
@section('page-title', 'User Profile')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- User Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-8 text-center">
                <div class="w-24 h-24 bg-white/20 backdrop-blur rounded-2xl mx-auto flex items-center justify-center mb-4 border-4 border-white/50">
                    <span class="text-white text-4xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                </div>
                <h3 class="text-xl font-bold text-white">{{ $user->name }}</h3>
                <p class="text-indigo-100 text-sm mt-1">@if($user->roles->isNotEmpty()) 
                    {{ ucfirst($user->roles->first()->name) }} 
                @else 
                    No Role Assigned 
                @endif</p>
                <div class="mt-4">
                    @if($user->is_active)
                        <span class="px-3 py-1 bg-emerald-500/20 text-white rounded-full text-xs font-medium">
                            <i class="fas fa-circle text-emerald-300 text-[8px] mr-1"></i> Active
                        </span>
                    @else
                        <span class="px-3 py-1 bg-red-500/20 text-white rounded-full text-xs font-medium">
                            <i class="fas fa-circle text-red-300 text-[8px] mr-1"></i> Inactive
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Username</p>
                        <p class="text-sm font-semibold text-slate-800 mt-1">{{ '@' . $user->username }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Email Address</p>
                        <p class="text-sm font-semibold text-slate-800 mt-1">{{ $user->email }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Phone Number</p>
                        <p class="text-sm font-semibold text-slate-800 mt-1">{{ $user->phone ?? 'Not provided' }}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                        <div>
                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Last Login</p>
                            <p class="text-sm font-semibold text-slate-800 mt-1">
                                {{ $user->last_login_at ? $user->last_login_at->format('d M Y') : 'Never' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Last IP</p>
                            <p class="text-sm font-semibold text-slate-800 mt-1">
                                {{ $user->last_login_ip ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Joined Date</p>
                            <p class="text-sm font-semibold text-slate-800 mt-1">
                                {{ $user->created_at->format('d M Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Last Updated</p>
                            <p class="text-sm font-semibold text-slate-800 mt-1">
                                {{ $user->updated_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex space-x-3">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-xl hover:bg-indigo-700 transition text-center">
                        <i class="fas fa-edit mr-2"></i>Edit User
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex-1 bg-slate-100 text-slate-700 px-4 py-2 rounded-xl hover:bg-slate-200 transition text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- User Activity & Details -->
    <div class="lg:col-span-2">
        <!-- Roles & Permissions -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">Roles & Permissions</h3>
                <p class="text-sm text-slate-500 mt-0.5">User roles and assigned permissions</p>
            </div>
            <div class="p-6">
                <div class="mb-6">
                    <p class="text-sm font-medium text-slate-700 mb-3">Assigned Roles</p>
                    <div class="flex flex-wrap gap-2">
                        @forelse($user->roles as $role)
                            <span class="px-3 py-1.5 text-sm font-medium rounded-xl 
                                @if($role->name == 'super-admin') bg-purple-100 text-purple-700
                                @elseif($role->name == 'admin') bg-indigo-100 text-indigo-700
                                @elseif($role->name == 'partner') bg-emerald-100 text-emerald-700
                                @elseif($role->name == 'staff') bg-amber-100 text-amber-700
                                @else bg-slate-100 text-slate-700
                                @endif">
                                <i class="fas fa-check-circle mr-1 text-xs"></i>
                                {{ ucfirst($role->name) }}
                            </span>
                        @empty
                            <p class="text-sm text-slate-500">No roles assigned</p>
                        @endforelse
                    </div>
                </div>
                
                <div>
                    <p class="text-sm font-medium text-slate-700 mb-3">Effective Permissions</p>
                    @php
                        $permissions = $user->getAllPermissions()->pluck('name')->toArray();
                        $groupedPermissions = [];
                        foreach ($permissions as $permission) {
                            $parts = explode(' ', $permission);
                            $action = $parts[0] ?? '';
                            $resource = $parts[1] ?? '';
                            $groupedPermissions[$resource][] = $action;
                        }
                    @endphp
                    
                    @if(!empty($groupedPermissions))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($groupedPermissions as $resource => $actions)
                                <div class="bg-slate-50 rounded-xl p-4">
                                    <p class="text-sm font-semibold text-slate-700 mb-2 capitalize">{{ $resource }}</p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($actions as $action)
                                            <span class="px-2 py-1 bg-white text-xs font-medium text-slate-600 rounded-lg border border-slate-200">
                                                {{ $action }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-500">No permissions assigned</p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">Recent Activity</h3>
                <p class="text-sm text-slate-500 mt-0.5">Latest user activities</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-0">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-plus text-emerald-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-800">Account Created</p>
                                <p class="text-xs text-slate-500">User registered in the system</p>
                            </div>
                        </div>
                        <span class="text-xs text-slate-400">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                    
                    @if($user->last_login_at)
                    <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-0">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-sign-in-alt text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-800">Last Login</p>
                                <p class="text-xs text-slate-500">From IP: {{ $user->last_login_ip ?? 'Unknown' }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-slate-400">{{ $user->last_login_at->diffForHumans() }}</span>
                    </div>
                    @endif
                    
                    @if($user->updated_at != $user->created_at)
                    <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-0">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-edit text-amber-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-800">Profile Updated</p>
                                <p class="text-xs text-slate-500">User information was modified</p>
                            </div>
                        </div>
                        <span class="text-xs text-slate-400">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection