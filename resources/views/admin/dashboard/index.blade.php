@extends('admin.layouts.master')

@section('title', 'Dashboard')
@section('page-title')
    Welcome back, {{ auth()->user()->name }}!
@endsection

@section('content')
<!-- Welcome Banner - Professional Gradient -->
<div class="relative overflow-hidden rounded-2xl mb-8">
    <div class="absolute inset-0 bg-gradient-to-r from-slate-700 via-slate-600 to-slate-700"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-10"></div>
    <div class="relative z-10 px-8 py-8 text-white">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-14 h-14 bg-white/10 backdrop-blur rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight">Manpower Fulfillment Dashboard</h2>
                        <p class="text-white/70 text-sm mt-1">Track and manage your recruitment activities in real-time</p>
                    </div>
                </div>
                <div class="flex items-center space-x-6 mt-2">
                    <div class="flex items-center space-x-2 text-sm bg-white/10 px-3 py-1.5 rounded-full backdrop-blur">
                        <i class="fas fa-calendar-alt"></i>
                        <span>{{ now()->format('l, d F Y') }}</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm bg-white/10 px-3 py-1.5 rounded-full backdrop-blur">
                        <i class="fas fa-clock"></i>
                        <span id="live-clock"></span>
                    </div>
                </div>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="w-24 h-24 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur border border-white/20 shadow-xl">
                    <i class="fas fa-briefcase text-4xl text-white/80"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Registration Distribution - Full Width -->
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-slate-800 flex items-center">
                    <i class="fas fa-chart-pie text-indigo-500 mr-2"></i>
                    Registration Distribution
                </h3>
                <p class="text-sm text-slate-500 mt-0.5">Candidates vs Employers overview</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-indigo-500 rounded-full"></div>
                    <span class="text-xs text-slate-600">Candidates</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                    <span class="text-xs text-slate-600">Employers</span>
                </div>
            </div>
        </div>
    </div>
    <div class="p-6">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
            <!-- Chart -->
            <div class="flex-shrink-0">
                <canvas id="distributionChart" width="260" height="260" style="width: 260px; height: 260px;"></canvas>
            </div>
            
            <!-- Statistics Cards -->
            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-5 w-full">
                <!-- Candidates Stats -->
                <a href="{{ route('admin.candidates.index') }}" class="group">
                    <div class="bg-indigo-50/30 rounded-xl p-5 border border-indigo-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-user-tie text-indigo-600 text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="text-base font-semibold text-slate-800">Candidates</h4>
                                    <p class="text-xs text-slate-500">Total registered</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-indigo-600">{{ number_format($totalCandidates ?? 0) }}</span>
                                <span class="text-sm text-slate-400 ml-1">({{ round(($totalCandidates / max(($totalCandidates + $totalEmployers), 1)) * 100) }}%)</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-slate-600">New Today</span>
                                    <span class="text-slate-700 font-medium">{{ number_format($newCandidatesToday ?? 0) }}</span>
                                </div>
                                <div class="w-full bg-indigo-200 rounded-full h-1.5">
                                    <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ min(($newCandidatesToday / 100) * 100, 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                
                <!-- Employers Stats -->
                <a href="{{ route('admin.clients.index') }}" class="group">
                    <div class="bg-emerald-50/30 rounded-xl p-5 border border-emerald-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-building text-emerald-600 text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="text-base font-semibold text-slate-800">Employers</h4>
                                    <p class="text-xs text-slate-500">Total registered</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-emerald-600">{{ number_format($totalEmployers ?? 0) }}</span>
                                <span class="text-sm text-slate-400 ml-1">({{ round(($totalEmployers / max(($totalCandidates + $totalEmployers), 1)) * 100) }}%)</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-slate-600">New Today</span>
                                    <span class="text-slate-700 font-medium">{{ number_format($newEmployersToday ?? 0) }}</span>
                                </div>
                                <div class="w-full bg-emerald-200 rounded-full h-1.5">
                                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ min(($newEmployersToday / 50) * 100, 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Summary Row -->
        <div class="mt-6 pt-5 border-t border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-3 bg-slate-50 rounded-lg">
                <p class="text-xs text-slate-500">Total Registrations</p>
                <p class="text-xl font-bold text-slate-800">{{ number_format(($totalCandidates ?? 0) + ($totalEmployers ?? 0)) }}</p>
            </div>
            <div class="text-center p-3 bg-slate-50 rounded-lg">
                <p class="text-xs text-slate-500">Candidates Share</p>
                <p class="text-xl font-bold text-indigo-600">{{ round(($totalCandidates / max(($totalCandidates + $totalEmployers), 1)) * 100) }}%</p>
            </div>
            <div class="text-center p-3 bg-slate-50 rounded-lg">
                <p class="text-xs text-slate-500">Employers Share</p>
                <p class="text-xl font-bold text-emerald-600">{{ round(($totalEmployers / max(($totalCandidates + $totalEmployers), 1)) * 100) }}%</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Records Tables -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Candidates Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-slate-800 flex items-center">
                        <i class="fas fa-user-tie text-indigo-500 mr-2"></i>
                        Recent Candidates
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Latest registered candidates</p>
                </div>
                <a href="{{ route('admin.candidates.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium flex items-center">
                    View All
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Candidate</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Trade</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Registered</th>
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
                                    <p class="text-sm font-medium text-slate-800">{{ $candidate->full_name }}</p>
                                    <p class="text-xs text-slate-500">{{ $candidate->candidate_id }}</p>
                                </div>
                            </div>
                         </div>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-600">{{ $candidate->email }}</p>
                            <p class="text-xs text-slate-400">{{ $candidate->phone }}</p>
                         </div>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-50 text-indigo-700">{{ $candidate->trade_name }}</span>
                         </div>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $candidate->registered_at->diffForHumans() }}
                         </div>
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
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-slate-800 flex items-center">
                        <i class="fas fa-building text-emerald-500 mr-2"></i>
                        Recent Employers
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Latest registered employers/clients</p>
                </div>
                <a href="{{ route('admin.clients.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center">
                    View All
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
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
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentEmployers ?? [] as $employer)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                    <span class="text-emerald-700 text-sm font-bold">{{ substr($employer->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-slate-800">{{ $employer->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $employer->client_id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-800">{{ $employer->organization_name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-600">{{ $employer->email }}</p>
                            <p class="text-xs text-slate-400">{{ $employer->phone }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700">{{ $employer->industry_type }}</span>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    
    // Doughnut Chart
    document.addEventListener('DOMContentLoaded', function() {
        const totalCandidates = {{ $totalCandidates ?? 0 }};
        const totalEmployers = {{ $totalEmployers ?? 0 }};
        
        const ctx = document.getElementById('distributionChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Candidates', 'Employers'],
                datasets: [{
                    data: [totalCandidates, totalEmployers],
                    backgroundColor: ['#6366f1', '#10b981'],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '65%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#f1f5f9',
                        bodyColor: '#cbd5e1',
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection