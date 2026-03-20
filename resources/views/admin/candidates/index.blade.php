@extends('admin.layouts.master')

@section('title', 'Candidate Management')
@section('page-title', 'Manage Candidates')

@section('content')
<!-- Statistics Cards -->
<!-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
        </div>
        <h3 class="text-2xl font-bold text-slate-800">{{ number_format($statistics['total']) }}</h3>
        <p class="text-sm text-slate-500">Total Candidates</p>
    </div>
    
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mb-4">
            <i class="fas fa-clock text-yellow-600 text-xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-slate-800">{{ number_format($statistics['pending']) }}</h3>
        <p class="text-sm text-slate-500">Pending Review</p>
    </div>
    
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
            <i class="fas fa-check-circle text-green-600 text-xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-slate-800">{{ number_format($statistics['verified']) }}</h3>
        <p class="text-sm text-slate-500">Verified Candidates</p>
    </div>
    
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
            <i class="fas fa-briefcase text-purple-600 text-xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-slate-800">{{ number_format($statistics['placed']) }}</h3>
        <p class="text-sm text-slate-500">Placed Candidates</p>
    </div>
</div> -->

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800">All Candidates</h3>
            <p class="text-sm text-slate-500">Manage candidate registrations from the portal</p>
        </div>
        <div class="flex items-center space-x-2">
            <!-- Export Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="bg-white border border-slate-200 text-slate-700 px-4 py-2 rounded-xl hover:bg-slate-50 transition flex items-center">
                    <i class="fas fa-download mr-2"></i>Export
                    <i class="fas fa-chevron-down ml-2 text-xs"></i>
                </button>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 z-50 py-1">
                    <a href="{{ route('admin.candidates.export.excel', request()->query()) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                        <i class="fas fa-file-excel text-green-600 mr-2"></i>Export as Excel
                    </a>
                    <a href="{{ route('admin.candidates.export.csv', request()->query()) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                        <i class="fas fa-file-csv text-blue-600 mr-2"></i>Export as CSV
                    </a>
                    <a href="{{ route('admin.candidates.export.pdf', request()->query()) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                        <i class="fas fa-file-pdf text-red-600 mr-2"></i>Export as PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <!-- Search and Filter -->
        <form method="GET" action="{{ route('admin.candidates.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" placeholder="Search by name, email, phone, ID..." 
                       value="{{ request('search') }}"
                       class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            
           {{-- <select name="status" class="px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                <option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                <option value="selected" {{ request('status') == 'selected' ? 'selected' : '' }}>Selected</option>
                <option value="placed" {{ request('status') == 'placed' ? 'selected' : '' }}>Placed</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            
            <select name="verification_status" class="px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Verification</option>
                <option value="pending" {{ request('verification_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="document_verified" {{ request('verification_status') == 'document_verified' ? 'selected' : '' }}>Document Verified</option>
                <option value="background_checked" {{ request('verification_status') == 'background_checked' ? 'selected' : '' }}>Background Checked</option>
                <option value="fully_verified" {{ request('verification_status') == 'fully_verified' ? 'selected' : '' }}>Fully Verified</option>
                <option value="rejected" {{ request('verification_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select> --}}
            
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition">
                <i class="fas fa-filter mr-2"></i>Apply Filters
            </button>
        </form>
        
        <!-- Candidates Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Candidate</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Experience</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Trade/Industry</th>
                        <!-- <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Verification</th> -->
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Registered</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($candidates as $candidate)
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
                            <p class="text-xs text-slate-400">Passport: {{ $candidate->passport_number ?? 'N/A' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-600">India: {{ $candidate->indian_experience_years }} yrs</p>
                            <p class="text-xs text-slate-500">Overseas: {{ $candidate->overseas_experience_years }} yrs</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-slate-800">{{ $candidate->trade_name }}</p>
                            <p class="text-xs text-slate-500">{{ $candidate->industry_type }}</p>
                        </td>
                        {{--
                        <td class="px-6 py-4">
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
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                @if($candidate->verification_status == 'pending') bg-gray-100 text-gray-700
                                @elseif($candidate->verification_status == 'document_verified') bg-blue-100 text-blue-700
                                @elseif($candidate->verification_status == 'background_checked') bg-indigo-100 text-indigo-700
                                @elseif($candidate->verification_status == 'fully_verified') bg-green-100 text-green-700
                                @else bg-red-100 text-red-700
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $candidate->verification_status)) }}
                            </span>
                        </td> --}}
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $candidate->registered_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.candidates.show', $candidate->id) }}" class="p-1 hover:bg-indigo-50 rounded-lg transition" title="View Details">
                                    <i class="fas fa-eye text-indigo-600"></i>
                                </a>
                                @if($candidate->resume_path)
                                <a href="{{ route('admin.candidates.download-resume', $candidate->id) }}" class="p-1 hover:bg-emerald-50 rounded-lg transition" title="Download Resume">
                                    <i class="fas fa-download text-emerald-600"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-users text-4xl text-slate-300 mb-2"></i>
                                <p class="text-sm text-slate-500">No candidates found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $candidates->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection