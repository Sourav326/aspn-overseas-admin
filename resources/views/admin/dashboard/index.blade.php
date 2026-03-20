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

<!-- Statistics Cards - Candidate Focused -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Candidates Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 stat-card">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-indigo-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-green-600 bg-green-50 px-3 py-1 rounded-full">
                <i class="fas fa-arrow-up mr-1"></i> {{ $candidateGrowth ?? 0 }}%
            </span>
        </div>
        <h3 class="text-3xl font-bold text-slate-800 mb-1">{{ number_format($totalCandidates ?? 0) }}</h3>
        <p class="text-sm text-slate-500 mb-3">Total Candidates</p>
        <div class="flex items-center justify-between text-xs">
            <span class="text-slate-400">Target: 5,000</span>
            <span class="text-indigo-600 font-medium">{{ round(($totalCandidates/5000)*100) }}%</span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
            <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ min(round(($totalCandidates/5000)*100), 100) }}%"></div>
        </div>
    </div>
    
    <!-- New Candidates Today Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 stat-card">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-plus text-emerald-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                Last 24h
            </span>
        </div>
        <h3 class="text-3xl font-bold text-slate-800 mb-1">{{ number_format($newCandidatesToday ?? 0) }}</h3>
        <p class="text-sm text-slate-500 mb-3">New Candidates</p>
        <div class="flex items-center space-x-2 text-xs">
            <span class="text-slate-400">vs yesterday:</span>
            <span class="text-green-600 font-medium">
                <i class="fas fa-arrow-up text-xs mr-1"></i>{{ $candidateGrowthDaily ?? 0 }}%
            </span>
        </div>
    </div>
    
    <!-- Verified Candidates Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 stat-card">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-blue-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                Verified
            </span>
        </div>
        <h3 class="text-3xl font-bold text-slate-800 mb-1">{{ number_format($verifiedCandidates ?? 0) }}</h3>
        <p class="text-sm text-slate-500 mb-3">Fully Verified</p>
        <div class="flex items-center space-x-2">
            <div class="w-full bg-slate-100 rounded-full h-1.5">
                <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $verificationRate ?? 0 }}%"></div>
            </div>
            <span class="text-xs text-slate-500">{{ $verificationRate ?? 0 }}%</span>
        </div>
    </div>
    
    <!-- Placed Candidates Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 stat-card">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-briefcase text-purple-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-purple-600 bg-purple-50 px-3 py-1 rounded-full">
                Success Rate
            </span>
        </div>
        <h3 class="text-3xl font-bold text-slate-800 mb-1">{{ number_format($placedCandidates ?? 0) }}</h3>
        <p class="text-sm text-slate-500 mb-3">Placed Candidates</p>
        <div class="flex items-center space-x-2 text-xs">
            <span class="text-slate-400">Placement Rate:</span>
            <span class="text-green-600 font-medium">{{ $placementRate ?? 0 }}%</span>
        </div>
    </div>
</div>

<!-- Quick Stats Row -->
<!-- <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8"> -->
    <!-- Today's Overview -->
    <!-- <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Today's Overview</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-plus text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-700">New Registrations</p>
                        <p class="text-xs text-slate-400">Today</p>
                    </div>
                </div>
                <span class="text-2xl font-bold text-indigo-600">{{ $newCandidatesToday ?? 0 }}</span>
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
                <span class="text-2xl font-bold text-emerald-600">{{ $verificationsToday ?? 0 }}</span>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-amber-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-700">Pending Review</p>
                        <p class="text-xs text-slate-400">Awaiting verification</p>
                    </div>
                </div>
                <span class="text-2xl font-bold text-amber-600">{{ $pendingCandidates ?? 0 }}</span>
            </div>
        </div>
    </div> -->
    
    <!-- Candidate Status Distribution -->
    <!-- <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-slate-800">Candidate Status</h3>
            <a href="{{ route('admin.candidates.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all</a>
        </div>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                    <span class="text-sm text-slate-600">Pending</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-semibold text-slate-800">{{ $statusCounts['pending'] ?? 0 }}</span>
                    <span class="text-xs text-slate-400 w-12">{{ round(($statusCounts['pending'] / max($totalCandidates, 1)) * 100) }}%</span>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5">
                <div class="rounded-full h-1.5 bg-yellow-500" style="width: {{ round(($statusCounts['pending'] / max($totalCandidates, 1)) * 100) }}%"></div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                    <span class="text-sm text-slate-600">Under Review</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-semibold text-slate-800">{{ $statusCounts['under_review'] ?? 0 }}</span>
                    <span class="text-xs text-slate-400 w-12">{{ round(($statusCounts['under_review'] / max($totalCandidates, 1)) * 100) }}%</span>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5">
                <div class="rounded-full h-1.5 bg-blue-500" style="width: {{ round(($statusCounts['under_review'] / max($totalCandidates, 1)) * 100) }}%"></div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full bg-green-500"></span>
                    <span class="text-sm text-slate-600">Verified/Selected</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-semibold text-slate-800">{{ ($statusCounts['verified'] ?? 0) + ($statusCounts['selected'] ?? 0) }}</span>
                    <span class="text-xs text-slate-400 w-12">{{ round((($statusCounts['verified'] ?? 0) + ($statusCounts['selected'] ?? 0)) / max($totalCandidates, 1) * 100) }}%</span>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5">
                <div class="rounded-full h-1.5 bg-green-500" style="width: {{ round((($statusCounts['verified'] ?? 0) + ($statusCounts['selected'] ?? 0)) / max($totalCandidates, 1) * 100) }}%"></div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full bg-purple-500"></span>
                    <span class="text-sm text-slate-600">Placed</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-semibold text-slate-800">{{ $statusCounts['placed'] ?? 0 }}</span>
                    <span class="text-xs text-slate-400 w-12">{{ round(($statusCounts['placed'] / max($totalCandidates, 1)) * 100) }}%</span>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5">
                <div class="rounded-full h-1.5 bg-purple-500" style="width: {{ round(($statusCounts['placed'] / max($totalCandidates, 1)) * 100) }}%"></div>
            </div>
        </div>
        
        <div class="mt-6 pt-4 border-t border-slate-100">
            <div class="flex items-center justify-between text-sm">
                <span class="text-slate-500">Total Candidates</span>
                <span class="font-bold text-slate-800">{{ number_format($totalCandidates ?? 0) }}</span>
            </div>
        </div>
    </div> -->
    
    <!-- Quick Actions - Candidate Focused -->
    <!-- <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Quick Actions</h3>
        <div class="space-y-3">
            <a href="{{ route('admin.candidates.index') }}" class="block p-4 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition-all group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-indigo-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-tie text-indigo-700"></i>
                        </div>
                        <div>
                            <p class="font-medium text-indigo-900">View All Candidates</p>
                            <p class="text-xs text-indigo-600">Manage candidate profiles</p>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right text-indigo-400 group-hover:translate-x-1 transition"></i>
                </div>
            </a>
            
            <a href="{{ route('admin.candidates.index') }}?status=pending" class="block p-4 bg-amber-50 hover:bg-amber-100 rounded-xl transition-all group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-amber-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-amber-700"></i>
                        </div>
                        <div>
                            <p class="font-medium text-amber-900">Pending Reviews</p>
                            <p class="text-xs text-amber-600">{{ $pendingCandidates ?? 0 }} candidates need attention</p>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right text-amber-400 group-hover:translate-x-1 transition"></i>
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
                            <p class="text-xs text-emerald-600">Download candidate data</p>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right text-emerald-400 group-hover:translate-x-1 transition"></i>
                </div>
            </a>
        </div>
    </div> -->
<!-- </div> -->

<!-- Recent Candidates Table -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Recent Candidates -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Recent Candidates</h3>
                <p class="text-xs text-slate-500 mt-0.5">Latest registered candidates</p>
            </div>
            <a href="{{ route('admin.candidates.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium flex items-center">
                View All
                <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Candidate</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Trade</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Industry Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Registered</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentCandidates ?? [] as $candidate)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <span class="text-indigo-700 text-sm font-bold">{{ substr($candidate->first_name, 0, 1) }}{{ substr($candidate->last_name, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-slate-800">{{ $candidate->full_name }}</p>
                                    <p class="text-xs text-slate-500">{{ $candidate->candidate_id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-600">{{ $candidate->email }}</p>
                            <p class="text-xs text-slate-400">{{ $candidate->phone }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-slate-800">{{ $candidate->trade_name }}</p>
                        </td>
                        <!-- <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                @if($candidate->status == 'pending') bg-yellow-100 text-yellow-700
                                @elseif($candidate->status == 'under_review') bg-blue-100 text-blue-700
                                @elseif($candidate->status == 'shortlisted') bg-purple-100 text-purple-700
                                @elseif($candidate->status == 'selected') bg-green-100 text-green-700
                                @elseif($candidate->status == 'placed') bg-emerald-100 text-emerald-700
                                @else bg-red-100 text-red-700
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $candidate->status)) }}
                            </span>
                        </td> -->
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $candidate->industry_type }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $candidate->registered_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-user-tie text-4xl text-slate-300 mb-2"></i>
                                <p class="text-sm text-slate-500">No candidates found</p>
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
        <!-- <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl p-6 shadow-lg">
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
        </div> -->
        
        <!-- Pending Verification Tasks -->
        <!-- <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-slate-800">Pending Tasks</h3>
                <span class="px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-xs font-medium">{{ $pendingCandidates ?? 0 }} total</span>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-amber-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">Document Verification</p>
                            <p class="text-xs text-slate-400">Candidates to verify</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-lg text-sm font-bold">{{ $pendingVerifications ?? 0 }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-alt text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">Background Check</p>
                            <p class="text-xs text-slate-400">In progress</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-bold">{{ $pendingBackgroundChecks ?? 0 }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-briefcase text-purple-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">Placement Process</p>
                            <p class="text-xs text-slate-400">Awaiting confirmation</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-lg text-sm font-bold">{{ $pendingPlacements ?? 0 }}</span>
                </div>
            </div>
            
            <a href="{{ route('admin.candidates.index') }}?status=pending" class="block text-center mt-4 text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                View all pending <i class="fas fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div> -->
        
        <!-- Quick Stats -->
        <!-- <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100">
            <h3 class="text-lg font-bold text-emerald-800 mb-3">Today's Stats</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-emerald-600 text-xs">Verification Rate</p>
                    <p class="text-2xl font-bold text-emerald-800">{{ $verificationRate ?? 0 }}%</p>
                    <p class="text-xs text-emerald-600">↑ {{ $verificationGrowth ?? 0 }}% from yesterday</p>
                </div>
                <div>
                    <p class="text-emerald-600 text-xs">Placement Rate</p>
                    <p class="text-2xl font-bold text-emerald-800">{{ $placementRate ?? 0 }}%</p>
                    <p class="text-xs text-emerald-600">Target: 30%</p>
                </div>
            </div>
        </div> -->
    </div>
</div>

<!-- Recent Activity - Candidate Focused -->
<!-- <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Recent Activity</h3>
            <p class="text-sm text-slate-500">Latest candidate activities</p>
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
                    <p class="text-sm font-medium text-slate-800">New candidate registered</p>
                    <p class="text-xs text-slate-500">John Doe - Electrician</p>
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
                    <p class="text-xs text-slate-500">Sarah Johnson - Documents verified</p>
                </div>
            </div>
            <span class="text-xs text-slate-400">1 hour ago</span>
        </div>
        
        <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-0">
            <div class="flex items-center space-x-4">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-briefcase text-purple-600 text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-800">Candidate placed</p>
                    <p class="text-xs text-slate-500">Mike Smith - Placed in Dubai</p>
                </div>
            </div>
            <span class="text-xs text-slate-400">2 hours ago</span>
        </div>
        
        <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-0">
            <div class="flex items-center space-x-4">
                <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-amber-600 text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-800">New resume uploaded</p>
                    <p class="text-xs text-slate-500">Ahmed Ali - Uploaded new CV</p>
                </div>
            </div>
            <span class="text-xs text-slate-400">3 hours ago</span>
        </div>
    </div>
</div> -->
@endsection