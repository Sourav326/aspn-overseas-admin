@extends('admin.layouts.master')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100">
        <h3 class="text-lg font-bold text-slate-800">Edit User: {{ $user->name }}</h3>
        <p class="text-sm text-slate-500 mt-0.5">Update user information and roles</p>
    </div>
    
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                    class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
                    placeholder="Enter full name" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-slate-700 mb-2">Username <span class="text-red-500">*</span></label>
                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" 
                    class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('username') border-red-500 @enderror"
                    placeholder="Enter username" required>
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                    class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
                    placeholder="Enter email address" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-slate-700 mb-2">Phone Number <span class="text-red-500">*</span></label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                    class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('phone') border-red-500 @enderror"
                    placeholder="Enter phone number" required>
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">New Password</label>
                <input type="password" name="password" id="password" 
                    class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-red-500 @enderror"
                    placeholder="Leave blank to keep current">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                    class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Confirm new password">
            </div>
            
            <!-- Roles -->
            <div>
                <label for="roles" class="block text-sm font-medium text-slate-700 mb-2">Roles <span class="text-red-500">*</span></label>
                <select name="roles[]" id="roles" multiple class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('roles') border-red-500 @enderror" size="5" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', $userRoles ?? [])) ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-400 mt-1">Hold Ctrl/Cmd to select multiple roles</p>
                @error('roles')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="is_active" value="1" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500" {{ old('is_active', $user->is_active) == 1 ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-slate-700">Active</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="is_active" value="0" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500" {{ old('is_active', $user->is_active) == 0 ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-slate-700">Inactive</span>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="flex items-center space-x-3 mt-8 pt-4 border-t border-slate-100">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition">
                <i class="fas fa-save mr-2"></i>Update User
            </button>
            <a href="{{ route('admin.users.index') }}" class="px-6 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
        </div>
    </form>
</div>
@endsection