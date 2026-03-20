<?php

namespace App\Exports;

use App\Models\Candidate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CandidatesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;
    
    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }
    
    public function collection()
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
        
        return $query->get();
    }
    
    public function headings(): array
    {
        return [
            'Candidate ID',
            'Name',
            'Email',
            'Phone',
            'WhatsApp',
            'Passport Number',
            'Indian Experience',
            'Overseas Experience',
            'Trade Name',
            'Industry Type',
            'Status',
            'Verification Status',
            'Registered At',
        ];
    }
    
    public function map($candidate): array
    {
        return [
            $candidate->candidate_id,
            $candidate->full_name,
            $candidate->email,
            $candidate->phone,
            $candidate->whatsapp_number,
            $candidate->passport_number,
            $candidate->indian_experience_years,
            $candidate->overseas_experience_years,
            $candidate->trade_name,
            $candidate->industry_type,
            ucfirst($candidate->status),
            ucfirst(str_replace('_', ' ', $candidate->verification_status)),
            $candidate->registered_at->format('Y-m-d H:i:s'),
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}