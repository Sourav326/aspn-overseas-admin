<?php

namespace App\Exports;

use App\Models\Candidate;
use Barryvdh\DomPDF\Facade\Pdf;

class CandidatesPdfExport
{
    protected $filters;
    
    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }
    
    public function download()
    {
        $query = Candidate::query();
        
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        
        if (!empty($this->filters['verification_status'])) {
            $query->where('verification_status', $this->filters['verification_status']);
        }
        
        if (!empty($this->filters['trade'])) {
            $query->where('trade_name', 'like', "%{$this->filters['trade']}%");
        }
        
        if (!empty($this->filters['date_from'])) {
            $query->whereDate('registered_at', '>=', $this->filters['date_from']);
        }
        
        if (!empty($this->filters['date_to'])) {
            $query->whereDate('registered_at', '<=', $this->filters['date_to']);
        }
        
        $candidates = $query->get();
        
        $data = [
            'candidates' => $candidates,
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'generated_by' => auth()->user()->name,
            'filters' => $this->filters,
            'total' => $candidates->count(),
        ];
        
        $pdf = Pdf::loadView('exports.candidates-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('candidates-' . now()->format('Y-m-d-His') . '.pdf');
    }
}