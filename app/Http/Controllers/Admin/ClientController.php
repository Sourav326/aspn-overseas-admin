<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ClientsExport;
use App\Exports\ClientsPdfExport;
use Maatwebsite\Excel\Facades\Excel;


class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::with('user', 'verifiedBy');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('organization_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('client_id', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by verification status
        if ($request->filled('verification_status')) {
            $query->where('verification_status', $request->verification_status);
        }
        
        // Filter by industry
        if ($request->filled('industry')) {
            $query->where('industry_type', $request->industry);
        }
        
        $clients = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $statistics = [
            'total' => Client::count(),
            'pending' => Client::where('status', 'pending')->count(),
            'approved' => Client::where('status', 'approved')->count(),
            'active' => Client::where('status', 'active')->count(),
            'suspended' => Client::where('status', 'suspended')->count(),
            'rejected' => Client::where('status', 'rejected')->count(),
            'verified' => Client::where('verification_status', 'verified')->count(),
        ];
        
        $industries = Client::distinct()->pluck('industry_type');
        
        return view('admin.clients.index', compact('clients', 'statistics', 'industries'));
    }
    
    public function show($id)
    {
        $client = Client::with(['user', 'verifiedBy'])->findOrFail($id);
        return view('admin.clients.show', compact('client'));
    }
    
    public function verify(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        
        $request->validate([
            'verification_status' => 'required|in:pending,verified,rejected',
            'status' => 'required|in:pending,approved,active,suspended,rejected',
            'verification_notes' => 'nullable|string',
        ]);
        
        $client->update([
            'verification_status' => $request->verification_status,
            'status' => $request->status,
            'verification_notes' => $request->verification_notes,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);
        
        return redirect()->route('admin.clients.index')
            ->with('success', 'Client status updated successfully.');
    }
    
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        
        return redirect()->route('admin.clients.index')
            ->with('success', 'Client deleted successfully.');
    }
    /**
     * Export clients to Excel
     */
    public function exportExcel(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'status' => $request->status,
            'verification_status' => $request->verification_status,
            'industry' => $request->industry,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ];
        
        return Excel::download(new ClientsExport($filters), 'clients-' . now()->format('Y-m-d-His') . '.xlsx');
    }

    /**
     * Export clients to CSV
     */
    public function exportCsv(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'status' => $request->status,
            'verification_status' => $request->verification_status,
            'industry' => $request->industry,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ];
        
        return Excel::download(new ClientsExport($filters), 'clients-' . now()->format('Y-m-d-His') . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export clients to PDF
     */
    public function exportPdf(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'status' => $request->status,
            'verification_status' => $request->verification_status,
            'industry' => $request->industry,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ];
        
        $pdfExport = new ClientsPdfExport($filters);
        return $pdfExport->download();
    }
}