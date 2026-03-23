<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Candidate;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

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
        
        // Employer/Client Statistics
        $totalEmployers = Client::count();
        $newEmployersToday = Client::whereDate('registered_at', today())->count();
        $activeEmployers = Client::where('status', 'active')->count();
        
        // Calculate growth rates
        $candidateGrowth = $this->calculateCandidateGrowth();
        $candidateGrowthDaily = $this->calculateDailyCandidateGrowth();
        $employerGrowth = $this->calculateEmployerGrowth();
        
        // Calculate rates
        $verificationRate = $totalCandidates > 0 ? round(($verifiedCandidates / $totalCandidates) * 100) : 0;
        
        // Status counts for candidates
        $statusCounts = [
            'pending' => Candidate::where('status', 'pending')->count(),
            'under_review' => Candidate::where('status', 'under_review')->count(),
            'shortlisted' => Candidate::where('status', 'shortlisted')->count(),
            'selected' => Candidate::where('status', 'selected')->count(),
            'verified' => Candidate::where('status', 'verified')->count(),
            'placed' => Candidate::where('status', 'placed')->count(),
            'rejected' => Candidate::where('status', 'rejected')->count(),
        ];
        
        // Status counts for employers
        $employerStatusCounts = [
            'pending' => Client::where('status', 'pending')->count(),
            'approved' => Client::where('status', 'approved')->count(),
            'active' => Client::where('status', 'active')->count(),
            'suspended' => Client::where('status', 'suspended')->count(),
            'rejected' => Client::where('status', 'rejected')->count(),
        ];
        
        // Recent candidates (last 5)
        $recentCandidates = Candidate::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        // Recent employers (last 5)
        $recentEmployers = Client::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard.index', compact(
            'totalCandidates',
            'newCandidatesToday',
            'verifiedCandidates',
            'placedCandidates',
            'pendingCandidates',
            'totalEmployers',
            'newEmployersToday',
            'activeEmployers',
            'candidateGrowth',
            'candidateGrowthDaily',
            'employerGrowth',
            'verificationRate',
            'statusCounts',
            'employerStatusCounts',
            'recentCandidates',
            'recentEmployers'
        ));
    }
    
    private function calculateCandidateGrowth()
    {
        $lastMonth = Candidate::whereMonth('registered_at', now()->subMonth()->month)->count();
        $thisMonth = Candidate::whereMonth('registered_at', now()->month)->count();
        
        if ($lastMonth == 0) {
            return $thisMonth > 0 ? 100 : 0;
        }
        
        return round((($thisMonth - $lastMonth) / $lastMonth) * 100);
    }
    
    private function calculateDailyCandidateGrowth()
    {
        $yesterday = Candidate::whereDate('registered_at', now()->subDay())->count();
        $today = Candidate::whereDate('registered_at', today())->count();
        
        if ($yesterday == 0) {
            return $today > 0 ? 100 : 0;
        }
        
        return round((($today - $yesterday) / $yesterday) * 100);
    }
    
    private function calculateEmployerGrowth()
    {
        $lastMonth = Client::whereMonth('registered_at', now()->subMonth()->month)->count();
        $thisMonth = Client::whereMonth('registered_at', now()->month)->count();
        
        if ($lastMonth == 0) {
            return $thisMonth > 0 ? 100 : 0;
        }
        
        return round((($thisMonth - $lastMonth) / $lastMonth) * 100);
    }
}