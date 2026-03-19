<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithEvents
{
    protected $filters;
    
    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = User::with('roles');
        
        // Apply filters if any
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
        
        return $query->get();
    }
    
    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Username',
            'Email',
            'Phone',
            'Roles',
            'Status',
            'Last Login',
            'Last IP',
            'Created At',
        ];
    }
    
    /**
    * @param mixed $user
    * @return array
    */
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->username,
            $user->email,
            $user->phone,
            $user->roles->pluck('name')->implode(', '),
            $user->is_active ? 'Active' : 'Inactive',
            $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : 'Never',
            $user->last_login_ip ?? 'N/A',
            $user->created_at->format('Y-m-d H:i:s'),
        ];
    }
    
    /**
    * @param Worksheet $sheet
    * @return array
    */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
            'A1:J1' => ['fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5']
            ]],
        ];
    }
    
    /**
    * @return array
    */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:J1')->applyFromArray([
                    'font' => [
                        'color' => ['rgb' => 'FFFFFF'],
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}