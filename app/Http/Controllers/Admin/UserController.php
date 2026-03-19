<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Make sure this import is correct
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use App\Exports\UsersExport;
use App\Exports\UsersPdfExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller // Extending the correct base Controller
{
    /**
     * Constructor with middleware
     */
    public function __construct()
    {
        // Apply middleware to controller actions
        // $this->middleware('permission:view users')->only(['index', 'show']);
        // $this->middleware('permission:create users')->only(['create', 'store']);
        // $this->middleware('permission:edit users')->only(['edit', 'update']);
        // $this->middleware('permission:delete users')->only(['destroy']);
    }

    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Filter by role
        if ($request->filled('role')) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get all roles for filter dropdown
        $roles = Role::all();
        
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users|max:255',
            'email' => 'required|email|unique:users|max:255',
            'phone' => 'required|string|unique:users|max:20',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'is_active' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_active' => $request->is_active ?? true,
        ]);

        // Assign roles
        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        
        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:20|unique:users,phone,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'is_active' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_active' => $request->is_active ?? $user->is_active,
        ];

        // Update password only if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // Sync roles
        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting super admin
        if ($user->hasRole('super-admin')) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete super admin user.');
        }

        // Prevent users from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle user active status.
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->hasRole('super-admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot change super admin status.'
            ], 403);
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully.',
            'status' => $user->is_active ? 'active' : 'inactive'
        ]);
    }

    /**
     * Export users to Excel
     */
    public function exportExcel(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'role' => $request->role,
            'status' => $request->status,
        ];
        
        return Excel::download(new UsersExport($filters), 'users-' . now()->format('Y-m-d-His') . '.xlsx');
    }

    /**
     * Export users to CSV
     */
    public function exportCsv(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'role' => $request->role,
            'status' => $request->status,
        ];
        
        return Excel::download(new UsersExport($filters), 'users-' . now()->format('Y-m-d-His') . '.csv');
    }

    /**
     * Export users to PDF
     */
    public function exportPdf(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'role' => $request->role,
            'status' => $request->status,
        ];
        
        $pdfExport = new UsersPdfExport($filters);
        return $pdfExport->download();
    }

    /**
     * Show export options modal
     */
    public function showExportModal()
    {
        $roles = Role::all();
        return view('admin.users.export-modal', compact('roles'));
    }
}