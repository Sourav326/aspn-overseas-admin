<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Candidate;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        // Candidate Statistics
        $totalCandidates = Candidate::count();
        $newCandidatesToday = Candidate::whereDate('registered_at', today())->count();
        $verifiedCandidates = Candidate::where('verification_status', 'fully_verified')->count();
        $placedCandidates = Candidate::where('status', 'placed')->count();
        $pendingCandidates = Candidate::where('status', 'pending')->count();
        
        // Calculate growth rates (example - you can calculate actual growth from previous day/week)
        $candidateGrowth = $this->calculateCandidateGrowth();
        $candidateGrowthDaily = $this->calculateDailyCandidateGrowth();
        
        // Calculate rates
        $verificationRate = $totalCandidates > 0 ? round(($verifiedCandidates / $totalCandidates) * 100) : 0;
        $placementRate = $totalCandidates > 0 ? round(($placedCandidates / $totalCandidates) * 100) : 0;
        
        // Today's verifications (example data)
        $verificationsToday = Candidate::whereDate('verified_at', today())->count();
        
        // Status counts for distribution
        $statusCounts = [
            'pending' => Candidate::where('status', 'pending')->count(),
            'under_review' => Candidate::where('status', 'under_review')->count(),
            'shortlisted' => Candidate::where('status', 'shortlisted')->count(),
            'selected' => Candidate::where('status', 'selected')->count(),
            'verified' => Candidate::where('status', 'verified')->count(),
            'placed' => Candidate::where('status', 'placed')->count(),
            'rejected' => Candidate::where('status', 'rejected')->count(),
        ];
        
        // Pending tasks counts
        $pendingVerifications = Candidate::where('verification_status', 'pending')->count();
        $pendingBackgroundChecks = Candidate::where('verification_status', 'document_verified')->count();
        $pendingPlacements = Candidate::where('status', 'selected')->count();
        
        // Recent candidates (last 5)
        $recentCandidates = Candidate::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        // Chart data for last 7 days (candidate registrations)
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('D');
            $chartData[] = Candidate::whereDate('registered_at', $date)->count();
        }
        
        // Verification growth (example)
        $verificationGrowth = 12; // You can calculate actual growth
        
        // Storage used (example)
        $storageUsed = 45;
        
        return view('admin.dashboard.index', compact(
            'totalCandidates',
            'newCandidatesToday',
            'verifiedCandidates',
            'placedCandidates',
            'pendingCandidates',
            'candidateGrowth',
            'candidateGrowthDaily',
            'verificationRate',
            'placementRate',
            'verificationsToday',
            'statusCounts',
            'pendingVerifications',
            'pendingBackgroundChecks',
            'pendingPlacements',
            'recentCandidates',
            'chartLabels',
            'chartData',
            'verificationGrowth',
            'storageUsed'
        ));
    }
    
    private function calculateCandidateGrowth()
    {
        // Calculate growth from previous month
        $lastMonth = Candidate::whereMonth('registered_at', now()->subMonth()->month)->count();
        $thisMonth = Candidate::whereMonth('registered_at', now()->month)->count();
        
        if ($lastMonth == 0) {
            return $thisMonth > 0 ? 100 : 0;
        }
        
        return round((($thisMonth - $lastMonth) / $lastMonth) * 100);
    }
    
    private function calculateDailyCandidateGrowth()
    {
        // Calculate growth from yesterday
        $yesterday = Candidate::whereDate('registered_at', now()->subDay())->count();
        $today = Candidate::whereDate('registered_at', today())->count();
        
        if ($yesterday == 0) {
            return $today > 0 ? 100 : 0;
        }
        
        return round((($today - $yesterday) / $yesterday) * 100);
    }
}