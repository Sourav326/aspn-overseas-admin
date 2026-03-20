<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ClientsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithEvents
{
    protected $filters;
    
    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }
    
    public function collection()
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
        
        return $query->get();
    }
    
    public function headings(): array
    {
        return [
            'Client ID',
            'Name',
            'Organization Name',
            'Email',
            'Phone',
            'WhatsApp',
            'Industry Type',
            'Status',
            'Verification Status',
            'Registered At',
            'Verified At',
        ];
    }
    
    public function map($client): array
    {
        return [
            $client->client_id,
            $client->name,
            $client->organization_name,
            $client->email,
            $client->phone,
            $client->whatsapp_number ?? 'N/A',
            $client->industry_type,
            ucfirst($client->status),
            ucfirst($client->verification_status),
            $client->registered_at ? $client->registered_at->format('Y-m-d H:i:s') : 'N/A',
            $client->verified_at ? $client->verified_at->format('Y-m-d H:i:s') : 'N/A',
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
            'A1:K1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF']]
            ],
        ];
    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:K1')->applyFromArray([
                    'font' => ['bold' => true],
                ]);
            },
        ];
    }
}