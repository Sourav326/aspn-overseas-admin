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
                    <span id="live-clock"></span>
                </div>
            </div>
        </div>
        <div class="mt-4 md:mt-0">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Dashboard" class="w-32 h-32 opacity-90">
        </div>
    </div>
</div>

<!-- Statistics Cards - Candidates & Employers -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Total Candidates Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-tie text-indigo-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-green-600 bg-green-50 px-3 py-1 rounded-full">
                <i class="fas fa-arrow-up mr-1"></i> {{ $candidateGrowth ?? 0 }}%
            </span>
        </div>
        <h3 class="text-3xl font-bold text-slate-800 mb-1">{{ number_format($totalCandidates ?? 0) }}</h3>
        <p class="text-sm text-slate-500 mb-3">Total Candidates</p>
        <!-- <div class="flex items-center justify-between text-xs">
            <span class="text-slate-400">Target: 5,000</span>
            <span class="text-indigo-600 font-medium">{{ round(($totalCandidates/5000)*100) }}%</span>
        </div> -->
        <!-- <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
            <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ min(round(($totalCandidates/5000)*100), 100) }}%"></div>
        </div> -->
    </div>
    
    <!-- Total Employers Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-building text-blue-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-green-600 bg-green-50 px-3 py-1 rounded-full">
                <i class="fas fa-arrow-up mr-1"></i> {{ $employerGrowth ?? 0 }}%
            </span>
        </div>
        <h3 class="text-3xl font-bold text-slate-800 mb-1">{{ number_format($totalEmployers ?? 0) }}</h3>
        <p class="text-sm text-slate-500 mb-3">Total Employers</p>
        <!-- <div class="flex items-center justify-between text-xs">
            <span class="text-slate-400">Target: 500</span>
            <span class="text-blue-600 font-medium">{{ round(($totalEmployers/500)*100) }}%</span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
            <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ min(round(($totalEmployers/500)*100), 100) }}%"></div>
        </div> -->
    </div>
    
    <!-- New Today -->
    <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-plus text-emerald-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                Last 24h
            </span>
        </div>
        <div class="flex items-baseline justify-between">
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ number_format($newCandidatesToday ?? 0) }}</p>
                <p class="text-xs text-slate-500">Candidates</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-slate-800">{{ number_format($newEmployersToday ?? 0) }}</p>
                <p class="text-xs text-slate-500">Employers</p>
            </div>
        </div>
        <!-- <div class="flex items-center justify-between mt-3 text-xs">
            <span class="text-slate-400">Candidates vs yesterday:</span>
            <span class="text-green-600 font-medium">
                <i class="fas fa-arrow-up text-xs mr-1"></i>{{ $candidateGrowthDaily ?? 0 }}%
            </span>
        </div> -->
    </div>
    
    
    <!-- Verified & Active -->
    <!-- <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-purple-600 text-xl"></i>
            </div>
            <span class="text-sm font-medium text-purple-600 bg-purple-50 px-3 py-1 rounded-full">
                Active Status
            </span>
        </div>
        <div class="flex items-baseline justify-between">
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ number_format($verifiedCandidates ?? 0) }}</p>
                <p class="text-xs text-slate-500">Verified Candidates</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-slate-800">{{ number_format($activeEmployers ?? 0) }}</p>
                <p class="text-xs text-slate-500">Active Employers</p>
            </div>
        </div>
        <div class="flex items-center justify-between mt-3 text-xs">
            <span class="text-slate-400">Verification Rate:</span>
            <span class="text-green-600 font-medium">{{ $verificationRate ?? 0 }}%</span>
        </div>
    </div> -->
</div>

<!-- Candidate & Employer Status Row -->
<!-- <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8"> -->
    <!-- Candidate Status Distribution -->
    <!-- <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-slate-800 flex items-center">
                <i class="fas fa-user-tie text-indigo-600 mr-2"></i>
                Candidate Status
            </h3>
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
    
    <!-- Employer Status Distribution -->
    <!-- <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-slate-800 flex items-center">
                <i class="fas fa-building text-blue-600 mr-2"></i>
                Employer Status
            </h3>
            <a href="{{ route('admin.clients.index') }}" class="text-sm text-blue-600 hover:text-blue-700">View all</a>
        </div>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                    <span class="text-sm text-slate-600">Pending</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-semibold text-slate-800">{{ $employerStatusCounts['pending'] ?? 0 }}</span>
                    <span class="text-xs text-slate-400 w-12">{{ round(($employerStatusCounts['pending'] / max($totalEmployers, 1)) * 100) }}%</span>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5">
                <div class="rounded-full h-1.5 bg-yellow-500" style="width: {{ round(($employerStatusCounts['pending'] / max($totalEmployers, 1)) * 100) }}%"></div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full bg-green-500"></span>
                    <span class="text-sm text-slate-600">Approved</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-semibold text-slate-800">{{ $employerStatusCounts['approved'] ?? 0 }}</span>
                    <span class="text-xs text-slate-400 w-12">{{ round(($employerStatusCounts['approved'] / max($totalEmployers, 1)) * 100) }}%</span>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5">
                <div class="rounded-full h-1.5 bg-green-500" style="width: {{ round(($employerStatusCounts['approved'] / max($totalEmployers, 1)) * 100) }}%"></div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                    <span class="text-sm text-slate-600">Active</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-semibold text-slate-800">{{ $employerStatusCounts['active'] ?? 0 }}</span>
                    <span class="text-xs text-slate-400 w-12">{{ round(($employerStatusCounts['active'] / max($totalEmployers, 1)) * 100) }}%</span>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5">
                <div class="rounded-full h-1.5 bg-blue-500" style="width: {{ round(($employerStatusCounts['active'] / max($totalEmployers, 1)) * 100) }}%"></div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full bg-red-500"></span>
                    <span class="text-sm text-slate-600">Suspended/Rejected</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-semibold text-slate-800">{{ ($employerStatusCounts['suspended'] ?? 0) + ($employerStatusCounts['rejected'] ?? 0) }}</span>
                    <span class="text-xs text-slate-400 w-12">{{ round((($employerStatusCounts['suspended'] ?? 0) + ($employerStatusCounts['rejected'] ?? 0)) / max($totalEmployers, 1) * 100) }}%</span>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-1.5">
                <div class="rounded-full h-1.5 bg-red-500" style="width: {{ round((($employerStatusCounts['suspended'] ?? 0) + ($employerStatusCounts['rejected'] ?? 0)) / max($totalEmployers, 1) * 100) }}%"></div>
            </div>
        </div>
        
        <div class="mt-6 pt-4 border-t border-slate-100">
            <div class="flex items-center justify-between text-sm">
                <span class="text-slate-500">Total Employers</span>
                <span class="font-bold text-slate-800">{{ number_format($totalEmployers ?? 0) }}</span>
            </div>
        </div>
    </div> -->
<!-- </div> -->

<!-- Recent Records Tables -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Recent Candidates Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-slate-800 flex items-center">
                    <i class="fas fa-user-tie text-indigo-600 mr-2"></i>
                    Recent Candidates
                </h3>
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
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $candidate->registered_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center">
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
    
    <!-- Recent Employers Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-slate-800 flex items-center">
                    <i class="fas fa-building text-blue-600 mr-2"></i>
                    Recent Employers
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Latest registered employers/clients</p>
            </div>
            <a href="{{ route('admin.clients.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center">
                View All
                <i class="fas fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Employer</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Organization</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Industry</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Registered</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentEmployers ?? [] as $employer)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="text-blue-700 text-sm font-bold">{{ substr($employer->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-slate-800">{{ $employer->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $employer->client_id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-slate-800">{{ $employer->organization_name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-600">{{ $employer->email }}</p>
                            <p class="text-xs text-slate-400">{{ $employer->phone }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                {{ $employer->industry_type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $employer->registered_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-building text-4xl text-slate-300 mb-2"></i>
                                <p class="text-sm text-slate-500">No employers found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 text-white">
        <h3 class="text-lg font-bold mb-4 flex items-center">
            <i class="fas fa-user-tie mr-2"></i>
            Candidate Quick Actions
        </h3>
        <div class="space-y-3">
            <a href="{{ route('admin.candidates.index') }}" class="block bg-white/20 hover:bg-white/30 rounded-xl p-3 transition">
                <div class="flex items-center justify-between">
                    <span>View All Candidates</span>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            <a href="{{ route('admin.candidates.index') }}?status=pending" class="block bg-white/20 hover:bg-white/30 rounded-xl p-3 transition">
                <div class="flex items-center justify-between">
                    <span>Review Pending Candidates ({{ $statusCounts['pending'] ?? 0 }})</span>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            <a href="{{ route('admin.candidates.export.excel') }}" class="block bg-white/20 hover:bg-white/30 rounded-xl p-3 transition">
                <div class="flex items-center justify-between">
                    <span>Export Candidates Report</span>
                    <i class="fas fa-download"></i>
                </div>
            </a>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl p-6 text-white">
        <h3 class="text-lg font-bold mb-4 flex items-center">
            <i class="fas fa-building mr-2"></i>
            Employer Quick Actions
        </h3>
        <div class="space-y-3">
            <a href="{{ route('admin.clients.index') }}" class="block bg-white/20 hover:bg-white/30 rounded-xl p-3 transition">
                <div class="flex items-center justify-between">
                    <span>View All Employers</span>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            <a href="{{ route('admin.clients.index') }}?status=pending" class="block bg-white/20 hover:bg-white/30 rounded-xl p-3 transition">
                <div class="flex items-center justify-between">
                    <span>Approve Pending Employers ({{ $employerStatusCounts['pending'] ?? 0 }})</span>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            <a href="{{ route('admin.clients.export.excel') }}" class="block bg-white/20 hover:bg-white/30 rounded-xl p-3 transition">
                <div class="flex items-center justify-between">
                    <span>Export Employers Report</span>
                    <i class="fas fa-download"></i>
                </div>
            </a>
        </div>
    </div>
</div> -->

<script>
    function updateClock() {
        const now = new Date();
        const time = now.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit',
            hour12: true 
        });
        const clockElement = document.getElementById('live-clock');
        if (clockElement) {
            clockElement.textContent = time;
        }
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>
@endsection