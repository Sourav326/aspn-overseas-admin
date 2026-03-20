@extends('admin.layouts.master')

@section('title', 'Candidate Details')
@section('page-title', 'Candidate Profile')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Candidate Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden sticky top-6">
            <!-- Profile Header -->
            <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 px-6 py-6 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mt-16 -mr-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -mb-12 -ml-12"></div>
                
                <div class="relative z-10">
                    <div class="w-24 h-24 bg-white/20 backdrop-blur rounded-2xl mx-auto flex items-center justify-center mb-3 shadow-xl border-4 border-white/50">
                        <span class="text-white text-4xl font-bold">{{ substr($candidate->first_name, 0, 1) }}{{ substr($candidate->last_name, 0, 1) }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-white">{{ $candidate->full_name }}</h3>
                    <p class="text-indigo-100 text-xs mt-1">{{ $candidate->candidate_id }}</p>
                    
                    <!-- Status Badges -->
                    <div class="flex justify-center gap-2 mt-3">
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-white/20 text-white backdrop-blur">
                            <i class="fas fa-user-check mr-1"></i> {{ ucfirst(str_replace('_', ' ', $candidate->status)) }}
                        </span>
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-white/20 text-white backdrop-blur">
                            <i class="fas fa-shield-alt mr-1"></i> {{ ucfirst(str_replace('_', ' ', $candidate->verification_status)) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Profile Details -->
            <div class="p-5 space-y-4">
                <!-- Contact Information -->
                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 flex items-center">
                        <i class="fas fa-address-card mr-1 text-indigo-400"></i>
                        Contact Information
                    </h4>
                    <div class="space-y-2">
                        <div class="flex items-center space-x-2 text-sm">
                            <div class="w-6 h-6 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-envelope text-indigo-600 text-xs"></i>
                            </div>
                            <span class="text-slate-600">{{ $candidate->email }}</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm">
                            <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-phone text-green-600 text-xs"></i>
                            </div>
                            <span class="text-slate-600">{{ $candidate->phone }}</span>
                        </div>
                        @if($candidate->whatsapp_number)
                        <div class="flex items-center space-x-2 text-sm">
                            <div class="w-6 h-6 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <i class="fab fa-whatsapp text-emerald-600 text-xs"></i>
                            </div>
                            <span class="text-slate-600">{{ $candidate->whatsapp_number }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Passport Details -->
                @if($candidate->passport_number)
                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 flex items-center">
                        <i class="fas fa-passport mr-1 text-indigo-400"></i>
                        Passport Details
                    </h4>
                    <div class="bg-slate-50 rounded-lg p-2">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600">Passport Number</span>
                            <span class="text-sm font-semibold text-slate-800">{{ $candidate->passport_number }}</span>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Professional Summary -->
                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 flex items-center">
                        <i class="fas fa-briefcase mr-1 text-indigo-400"></i>
                        Professional Summary
                    </h4>
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-3">
                        <p class="text-sm font-semibold text-slate-800">{{ $candidate->trade_name }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $candidate->industry_type }}</p>
                    </div>
                </div>
                
                <!-- Experience -->
                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 flex items-center">
                        <i class="fas fa-chart-line mr-1 text-indigo-400"></i>
                        Experience
                    </h4>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-2 text-center">
                            <p class="text-xl font-bold text-indigo-600">{{ $candidate->indian_experience_years }}</p>
                            <p class="text-xs text-slate-500">Indian Exp</p>
                        </div>
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg p-2 text-center">
                            <p class="text-xl font-bold text-purple-600">{{ $candidate->overseas_experience_years }}</p>
                            <p class="text-xs text-slate-500">Overseas Exp</p>
                        </div>
                    </div>
                    <div class="mt-1 text-center">
                        <p class="text-xs font-semibold text-slate-600">Total: <span class="text-indigo-600">{{ $candidate->total_experience }} Years</span></p>
                    </div>
                </div>
                
                <!-- Registration Info -->
                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 flex items-center">
                        <i class="fas fa-clock mr-1 text-indigo-400"></i>
                        Registration Info
                    </h4>
                    <div class="space-y-1 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Registered:</span>
                            <span class="text-slate-700">{{ $candidate->registered_at->format('d M Y, h:i A') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">IP Address:</span>
                            <span class="font-mono text-slate-700">{{ $candidate->registered_from_ip ?? 'N/A' }}</span>
                        </div>
                        @if($candidate->verified_at)
                        <div class="flex justify-between">
                            <span class="text-slate-500">Verified:</span>
                            <span class="text-slate-700">{{ $candidate->verified_at->format('d M Y, h:i A') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Column: Resume Card & Activity Timeline -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Resume Card - Compact Design -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
            @if($candidate->resume_path)
            <div>
                <div class="px-5 py-3 border-b border-slate-100 bg-gradient-to-r from-emerald-50 to-teal-50">
                    <h3 class="text-base font-bold text-slate-800 flex items-center">
                        <i class="fas fa-file-alt text-emerald-600 mr-2"></i>
                        Resume / CV
                    </h3>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center shadow-md">
                            <i class="fas fa-file-pdf text-white text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-slate-800 text-sm">{{ $candidate->resume_original_name ?? 'Resume Document' }}</p>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-xs text-slate-500 flex items-center gap-1">
                                    <i class="fas fa-database text-xs"></i> {{ number_format($candidate->resume_size / 1024, 2) }} KB
                                </span>
                                <span class="text-xs text-slate-500 flex items-center gap-1">
                                    <i class="fas fa-calendar-alt text-xs"></i> {{ $candidate->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('admin.candidates.download-resume', $candidate->id) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-sm rounded-lg hover:shadow-md transition-all duration-200 gap-2">
                            <i class="fas fa-download text-xs"></i>
                            <span>Download</span>
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div>
                <div class="px-5 py-3 border-b border-slate-100 bg-gradient-to-r from-gray-50 to-slate-50">
                    <h3 class="text-base font-bold text-slate-800 flex items-center">
                        <i class="fas fa-file-alt text-gray-600 mr-2"></i>
                        Resume / CV
                    </h3>
                </div>
                <div class="p-5">
                    <div class="flex items-center justify-center gap-3">
                        <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-file-upload text-gray-400 text-xl"></i>
                        </div>
                        <p class="text-sm text-slate-500">No resume uploaded yet</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Activity Timeline Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-gray-50">
                <h3 class="text-lg font-bold text-slate-800 flex items-center">
                    <i class="fas fa-history text-indigo-600 mr-2"></i>
                    Activity Timeline
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Track candidate journey and updates</p>
            </div>
            <div class="p-5">
                <div class="space-y-3">
                    <!-- Registration Activity -->
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-plus text-emerald-600 text-xs"></i>
                            </div>
                            <div class="w-px h-full bg-slate-200 ml-4 mt-2"></div>
                        </div>
                        <div class="flex-1 pb-3">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-slate-800">Candidate Registered</p>
                                <span class="text-xs text-slate-400">{{ $candidate->registered_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-500">Account created and profile submitted</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $candidate->registered_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    
                    <!-- Verification Activity -->
                    @if($candidate->verified_at)
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-circle text-purple-600 text-xs"></i>
                            </div>
                            <div class="w-px h-full bg-slate-200 ml-4 mt-2"></div>
                        </div>
                        <div class="flex-1 pb-3">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-slate-800">Candidate Verified</p>
                                <span class="text-xs text-slate-400">{{ $candidate->verified_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-500">Profile verification completed</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $candidate->verified_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Status Update Activity -->
                    @if($candidate->status != 'pending' || $candidate->verification_status != 'pending')
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-exchange-alt text-blue-600 text-xs"></i>
                            </div>
                            <div class="w-px h-full bg-slate-200 ml-4 mt-2"></div>
                        </div>
                        <div class="flex-1 pb-3">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-slate-800">Status Updated</p>
                                <span class="text-xs text-slate-400">{{ $candidate->updated_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-500">Status changed to: <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $candidate->status)) }}</span></p>
                            @if($candidate->verification_status != 'pending')
                            <p class="text-xs text-slate-500">Verification: <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $candidate->verification_status)) }}</span></p>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Profile Update Activity -->
                    @if($candidate->updated_at && $candidate->updated_at != $candidate->created_at && !$candidate->verified_at && $candidate->status == 'pending')
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-edit text-amber-600 text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-slate-800">Profile Updated</p>
                                <span class="text-xs text-slate-400">{{ $candidate->updated_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-500">Candidate information was modified</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $candidate->updated_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($candidate->status == 'pending' && $candidate->verification_status == 'pending' && !$candidate->verified_at && $candidate->updated_at == $candidate->created_at)
                    <div class="text-center py-6">
                        <i class="fas fa-hourglass-half text-slate-300 text-3xl mb-2"></i>
                        <p class="text-sm text-slate-500">No recent activity</p>
                        <p class="text-xs text-slate-400 mt-1">Candidate is waiting for review</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection