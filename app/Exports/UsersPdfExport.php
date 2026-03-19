<?php

namespace App\Exports;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class UsersPdfExport
{
    protected $filters;
    
    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }
    
    public function download()
    {
        $query = User::with('roles');
        
        // Apply filters
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }
        
        if (!empty($this->filters['role'])) {
            $query->whereHas('roles', function($q) {
                $q->where('name', $this->filters['role']);
            });
        }
        
        if (!empty($this->filters['status'])) {
            $query->where('is_active', $this->filters['status'] === 'active');
        }
        
        $users = $query->get();
        
        $data = [
            'users' => $users,
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'generated_by' => auth()->user()->name,
            'filters' => $this->filters
        ];
        
        $pdf = Pdf::loadView('exports.users-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('users-' . now()->format('Y-m-d-His') . '.pdf');
    }
}