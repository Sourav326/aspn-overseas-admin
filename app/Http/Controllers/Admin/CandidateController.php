<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CandidateDocument;
use App\Exports\CandidatesExport;
use App\Exports\CandidatesPdfExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view candidates')->only(['index', 'show']);
        $this->middleware('permission:verify candidates')->only(['verify', 'updateStatus']);
        $this->middleware('permission:export candidates')->only(['exportExcel', 'exportCsv', 'exportPdf']);
    }

    /**
     * Display list of candidates
     */
   public function index(Request $request)
{
    $query = Candidate::with('user'); // Remove 'verifiedBy' for now
    
    // Search functionality
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%")
              ->orWhere('candidate_id', 'like', "%{$search}%")
              ->orWhere('trade_name', 'like', "%{$search}%");
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

    // Filter by trade
    if ($request->filled('trade')) {
        $query->where('trade_name', 'like', "%{$request->trade}%");
    }

    // Filter by date range
    if ($request->filled('date_from')) {
        $query->whereDate('registered_at', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
        $query->whereDate('registered_at', '<=', $request->date_to);
    }

    $candidates = $query->orderBy('created_at', 'desc')->paginate(15);

    // Get statistics
    $statistics = [
        'total' => Candidate::count(),
        'pending' => Candidate::where('status', 'pending')->count(),
        'under_review' => Candidate::where('status', 'under_review')->count(),
        'shortlisted' => Candidate::where('status', 'shortlisted')->count(),
        'selected' => Candidate::where('status', 'selected')->count(),
        'placed' => Candidate::where('status', 'placed')->count(),
        'rejected' => Candidate::where('status', 'rejected')->count(),
        'verified' => Candidate::where('verification_status', 'fully_verified')->count(),
    ];

    // Get unique trades for filter
    $trades = Candidate::distinct()->pluck('trade_name');

    return view('admin.candidates.index', compact('candidates', 'statistics', 'trades'));
}

    /**
     * Show candidate details
     */
    public function show($id)
    {
        $candidate = Candidate::with(['user'])->findOrFail($id); // Remove 'verifiedBy' for now
        return view('admin.candidates.show', compact('candidate'));
    }

    /**
     * Verify candidate
     */
    public function verify(Request $request, $id)
    {
        $candidate = Candidate::findOrFail($id);

        $request->validate([
            'verification_status' => 'required|in:pending,document_verified,background_checked,fully_verified,rejected',
            'verification_notes' => 'nullable|string',
            'status' => 'required|in:pending,under_review,shortlisted,selected,rejected,placed',
        ]);

        $candidate->update([
            'verification_status' => $request->verification_status,
            'verification_notes' => $request->verification_notes,
            'status' => $request->status,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        return redirect()->route('admin.candidates.index')
            ->with('success', 'Candidate verification status updated successfully.');
    }

    /**
     * Update candidate status
     */
    public function updateStatus(Request $request, $id)
    {
        $candidate = Candidate::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,under_review,shortlisted,selected,rejected,placed',
        ]);

        $candidate->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'status' => $candidate->status
        ]);
    }

    /**
     * Download candidate resume
     */
    public function downloadResume($id)
    {
        $candidate = Candidate::findOrFail($id);
        
        if ($candidate->resume_path && Storage::disk('public')->exists($candidate->resume_path)) {
            return Storage::disk('public')->download($candidate->resume_path, $candidate->resume_original_name);
        }

        return redirect()->back()->with('error', 'Resume not found.');
    }

    /**
     * Delete candidate
     */
    public function destroy($id)
    {
        $candidate = Candidate::findOrFail($id);
        
        // Delete resume file if exists
        if ($candidate->resume_path && Storage::disk('public')->exists($candidate->resume_path)) {
            Storage::disk('public')->delete($candidate->resume_path);
        }
        
        $candidate->delete();

        return redirect()->route('admin.candidates.index')
            ->with('success', 'Candidate deleted successfully.');
    }

    /**
     * Export candidates to Excel
     */
    public function exportExcel(Request $request)
    {
        $filters = $request->only(['status', 'verification_status', 'trade', 'date_from', 'date_to']);
        return Excel::download(new CandidatesExport($filters), 'candidates-' . now()->format('Y-m-d-His') . '.xlsx');
    }

    /**
     * Export candidates to CSV
     */
    public function exportCsv(Request $request)
    {
        $filters = $request->only(['status', 'verification_status', 'trade', 'date_from', 'date_to']);
        return Excel::download(new CandidatesExport($filters), 'candidates-' . now()->format('Y-m-d-His') . '.csv');
    }

    /**
     * Export candidates to PDF
     */
    public function exportPdf(Request $request)
    {
        $filters = $request->only(['status', 'verification_status', 'trade', 'date_from', 'date_to']);
        $pdfExport = new CandidatesPdfExport($filters);
        return $pdfExport->download();
    }
}