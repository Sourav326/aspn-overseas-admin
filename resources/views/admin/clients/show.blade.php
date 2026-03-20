@extends('admin.layouts.master')

@section('title', 'Client Details')
@section('page-title', 'Client Profile')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Client Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden sticky top-6">
            <!-- Profile Header -->
            <div class="bg-gradient-to-br from-blue-600 to-indigo-600 px-6 py-6 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mt-16 -mr-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -mb-12 -ml-12"></div>
                
                <div class="relative z-10">
                    <div class="w-24 h-24 bg-white/20 backdrop-blur rounded-2xl mx-auto flex items-center justify-center mb-3 shadow-xl border-4 border-white/50">
                        <span class="text-white text-4xl font-bold">{{ substr($client->name, 0, 1) }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-white">{{ $client->name }}</h3>
                    <p class="text-indigo-100 text-xs mt-1">{{ $client->client_id }}</p>
                    
                    <!-- Status Badges -->
                    <div class="flex justify-center gap-2 mt-3">
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-white/20 text-white backdrop-blur">
                            <i class="fas fa-building mr-1"></i> {{ ucfirst($client->status) }}
                        </span>
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-white/20 text-white backdrop-blur">
                            <i class="fas fa-shield-alt mr-1"></i> {{ ucfirst($client->verification_status) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Profile Details -->
            <div class="p-5 space-y-4">
                <!-- Organization Information -->
                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 flex items-center">
                        <i class="fas fa-building mr-1 text-blue-400"></i>
                        Organization Information
                    </h4>
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-3">
                        <p class="text-sm font-semibold text-slate-800">{{ $client->organization_name }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">Industry: {{ $client->industry_type }}</p>
                    </div>
                </div>
                
                <!-- Contact Information -->
                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 flex items-center">
                        <i class="fas fa-address-card mr-1 text-blue-400"></i>
                        Contact Information
                    </h4>
                    <div class="space-y-2">
                        <div class="flex items-center space-x-2 text-sm">
                            <div class="w-6 h-6 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-envelope text-indigo-600 text-xs"></i>
                            </div>
                            <span class="text-slate-600">{{ $client->email }}</span>
                        </div>
                        <div class="flex items-center space-x-2 text-sm">
                            <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-phone text-green-600 text-xs"></i>
                            </div>
                            <span class="text-slate-600">{{ $client->phone }}</span>
                        </div>
                        @if($client->whatsapp_number)
                        <div class="flex items-center space-x-2 text-sm">
                            <div class="w-6 h-6 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <i class="fab fa-whatsapp text-emerald-600 text-xs"></i>
                            </div>
                            <span class="text-slate-600">{{ $client->whatsapp_number }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Registration Info -->
                <div>
                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 flex items-center">
                        <i class="fas fa-clock mr-1 text-blue-400"></i>
                        Registration Info
                    </h4>
                    <div class="space-y-1 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Registered:</span>
                            <span class="text-slate-700">{{ $client->registered_at->format('d M Y, h:i A') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">IP Address:</span>
                            <span class="font-mono text-slate-700">{{ $client->registered_from_ip ?? 'N/A' }}</span>
                        </div>
                        @if($client->verified_at)
                        <div class="flex justify-between">
                            <span class="text-slate-500">Verified:</span>
                            <span class="text-slate-700">{{ $client->verified_at->format('d M Y, h:i A') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <!-- Right Column: Status Management -->
    <div class="lg:col-span-2 space-y-6">
        {{--
        <!-- Status Update Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 flex items-center">
                            <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                            Update Status
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Manage client verification and account status</p>
                    </div>
                    <span class="text-xs text-slate-400">Last updated: {{ $client->updated_at->diffForHumans() }}</span>
                </div>
            </div>
            <div class="p-5">
                <form action="{{ route('admin.clients.verify', $client->id) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Account Status -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-flag-checkered text-blue-500 mr-1"></i>
                                Account Status
                            </label>
                            <div class="relative">
                                <select name="status" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-white">
                                    <option value="pending" {{ $client->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="approved" {{ $client->status == 'approved' ? 'selected' : '' }}>✅ Approved</option>
                                    <option value="active" {{ $client->status == 'active' ? 'selected' : '' }}>🚀 Active</option>
                                    <option value="suspended" {{ $client->status == 'suspended' ? 'selected' : '' }}>⛔ Suspended</option>
                                    <option value="rejected" {{ $client->status == 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <i class="fas fa-chevron-down text-slate-400"></i>
                                </div>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">
                                @if($client->status == 'pending')
                                    <i class="fas fa-clock text-yellow-500 mr-1"></i>Awaiting approval
                                @elseif($client->status == 'approved')
                                    <i class="fas fa-check-circle text-green-500 mr-1"></i>Approved, can start hiring
                                @elseif($client->status == 'active')
                                    <i class="fas fa-chart-line text-emerald-500 mr-1"></i>Active client
                                @elseif($client->status == 'suspended')
                                    <i class="fas fa-ban text-orange-500 mr-1"></i>Temporarily suspended
                                @elseif($client->status == 'rejected')
                                    <i class="fas fa-times-circle text-red-500 mr-1"></i>Application rejected
                                @endif
                            </p>
                        </div>
                        
                        <!-- Verification Status -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="fas fa-shield-alt text-blue-500 mr-1"></i>
                                Verification Status
                            </label>
                            <div class="relative">
                                <select name="verification_status" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-white">
                                    <option value="pending" {{ $client->verification_status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="verified" {{ $client->verification_status == 'verified' ? 'selected' : '' }}>✅ Verified</option>
                                    <option value="rejected" {{ $client->verification_status == 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <i class="fas fa-chevron-down text-slate-400"></i>
                                </div>
                            </div>
                            <!-- Verification Progress -->
                            <div class="mt-2">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1">
                                        <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-blue-600 rounded-full" style="width: 
                                                @if($client->verification_status == 'pending') 0%
                                                @elseif($client->verification_status == 'verified') 100%
                                                @else 0%
                                                @endif"></div>
                                        </div>
                                    </div>
                                    <span class="text-xs text-slate-500">
                                        @if($client->verification_status == 'pending') 0/2
                                        @elseif($client->verification_status == 'verified') 2/2
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Verification Notes -->
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            <i class="fas fa-sticky-note text-blue-500 mr-1"></i>
                            Verification Notes
                        </label>
                        <textarea name="verification_notes" rows="4" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none" placeholder="Add notes about verification process, document checks, interview feedback...">{{ $client->verification_notes }}</textarea>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="px-5 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg transition-all duration-200 flex items-center gap-2 text-sm">
                            <i class="fas fa-save"></i>
                            <span>Update Status</span>
                        </button>
                        <a href="{{ route('admin.clients.index') }}" class="px-5 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition-all duration-200 flex items-center gap-2 text-sm">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back to List</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        --}}
        <!-- Activity Timeline Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-gray-50">
                <h3 class="text-lg font-bold text-slate-800 flex items-center">
                    <i class="fas fa-history text-blue-600 mr-2"></i>
                    Activity Timeline
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Track client registration and updates</p>
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
                                <p class="text-sm font-semibold text-slate-800">Client Registered</p>
                                <span class="text-xs text-slate-400">{{ $client->registered_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-500">Account created and profile submitted</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $client->registered_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    
                    <!-- Verification Activity -->
                    @if($client->verified_at)
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-circle text-purple-600 text-xs"></i>
                            </div>
                            <div class="w-px h-full bg-slate-200 ml-4 mt-2"></div>
                        </div>
                        <div class="flex-1 pb-3">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-slate-800">Client Verified</p>
                                <span class="text-xs text-slate-400">{{ $client->verified_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-500">Profile verification completed</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $client->verified_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Status Update Activity -->
                    @if($client->status != 'pending')
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-exchange-alt text-blue-600 text-xs"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-slate-800">Status Updated</p>
                                <span class="text-xs text-slate-400">{{ $client->updated_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-500">Status changed to: <span class="font-medium">{{ ucfirst($client->status) }}</span></p>
                            @if($client->verification_status != 'pending')
                            <p class="text-xs text-slate-500">Verification: <span class="font-medium">{{ ucfirst($client->verification_status) }}</span></p>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    @if($client->status == 'pending' && $client->verification_status == 'pending' && !$client->verified_at)
                    <div class="text-center py-6">
                        <i class="fas fa-hourglass-half text-slate-300 text-3xl mb-2"></i>
                        <p class="text-sm text-slate-500">No recent activity</p>
                        <p class="text-xs text-slate-400 mt-1">Client is waiting for review</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

   
</div>
@endsection