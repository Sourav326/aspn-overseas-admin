<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic Statistics
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $newToday = User::whereDate('created_at', today())->count();
        $totalRoles = Role::count();
        
        // Calculate percentages
        $activePercentage = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0;
        $userGrowth = $this->calculateUserGrowth();
        
        // Recent users
        $recentUsers = User::with('roles')
            ->latest()
            ->take(5)
            ->get();
        
        // Chart data for last 7 days
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('D');
            $chartData[] = User::whereDate('created_at', $date)->count();
        }
        
        // Role distribution with colors
        $roles = Role::withCount('users')->get();
        $roleLabels = $roles->pluck('name')->map(function($role) {
            return ucfirst($role);
        })->toArray();
        $roleData = $roles->pluck('users_count')->toArray();
        
        // Role distribution for list view
        $roleDistribution = $roles->map(function($role) {
            $colors = [
                'super-admin' => '#8b5cf6',
                'admin' => '#6366f1',
                'partner' => '#10b981',
                'staff' => '#f59e0b',
                'user' => '#94a3b8'
            ];
            
            return (object)[
                'name' => ucfirst($role->name),
                'count' => $role->users_count,
                'color' => $colors[$role->name] ?? '#94a3b8'
            ];
        });
        
        return view('admin.dashboard.index', compact(
            'totalUsers',
            'activeUsers',
            'newToday',
            'totalRoles',
            'activePercentage',
            'userGrowth',
            'recentUsers',
            'chartLabels',
            'chartData',
            'roleLabels',
            'roleData',
            'roleDistribution'
        ));
    }
    
    private function calculateUserGrowth()
    {
        $lastMonth = User::whereMonth('created_at', now()->subMonth()->month)->count();
        $thisMonth = User::whereMonth('created_at', now()->month)->count();
        
        if ($lastMonth == 0) {
            return $thisMonth > 0 ? 100 : 0;
        }
        
        return round((($thisMonth - $lastMonth) / $lastMonth) * 100);
    }
}