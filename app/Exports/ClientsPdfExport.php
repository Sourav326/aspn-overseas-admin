<?php

namespace App\Exports;

use App\Models\Client;
use Barryvdh\DomPDF\Facade\Pdf;

class ClientsPdfExport
{
    protected $filters;
    
    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }
    
    public function download()
    {
        $query = Client::query();
        
        // Apply filters
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('organization_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('client_id', 'like', "%{$search}%");
            });
        }
        
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        
        if (!empty($this->filters['verification_status'])) {
            $query->where('verification_status', $this->filters['verification_status']);
        }
        
        if (!empty($this->filters['industry'])) {
            $query->where('industry_type', $this->filters['industry']);
        }
        
        if (!empty($this->filters['date_from'])) {
            $query->whereDate('registered_at', '>=', $this->filters['date_from']);
        }
        
        if (!empty($this->filters['date_to'])) {
            $query->whereDate('registered_at', '<=', $this->filters['date_to']);
        }
        
        $clients = $query->get();
        
        $data = [
            'clients' => $clients,
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'generated_by' => auth()->user()->name,
            'filters' => $this->filters,
            'total' => $clients->count(),
            'statistics' => [
                'pending' => Client::where('status', 'pending')->count(),
                'approved' => Client::where('status', 'approved')->count(),
                'active' => Client::where('status', 'active')->count(),
                'verified' => Client::where('verification_status', 'verified')->count(),
            ]
        ];
        
        $pdf = Pdf::loadView('exports.clients-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('clients-' . now()->format('Y-m-d-His') . '.pdf');
    }
}