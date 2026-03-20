<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create all permissions
        $permissions = [
            // Dashboard access
            'access dashboard',
            'access admin dashboard',
            
            // User management
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Role management
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'assign roles',
            
            // Permission management
            'view permissions',
            'assign permissions',
            
            // Candidate management
            'view candidates',
            'create candidates',
            'edit candidates',
            'delete candidates',
            'verify candidates',
            'export candidates',
            'import candidates',
            
            // Client management (Foreign Employers)
            'view clients',
            'create clients',
            'edit clients',
            'delete clients',
            'verify clients',
            'export clients',
            
            // Document management
            'view documents',
            'upload documents',
            'verify documents',
            'delete documents',
            
            // Partner management
            'view partners',
            'create partners',
            'edit partners',
            'delete partners',
            
            // Staff management
            'view staff',
            'create staff',
            'edit staff',
            'delete staff',
            
            // Demand management
            'view demands',
            'create demands',
            'edit demands',
            'delete demands',
            'assign demands',
            
            // Application management
            'view applications',
            'process applications',
            'approve applications',
            'reject applications',
            
            // Reports
            'view reports',
            'generate reports',
            'export reports',
            
            // Contact submissions
            'view contact submissions',
            'reply to contact submissions',
            'delete contact submissions',
            
            // Settings
            'view settings',
            'edit settings',
            
            // Candidate specific permissions (for frontend)
            'view own profile',
            'edit own profile',
            'view application status',
            
            // Client specific permissions (for frontend)
            'view own client profile',
            'edit own client profile',
            'post job demands',
            'view applications',
            'export clients',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $partnerRole = Role::firstOrCreate(['name' => 'partner']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $candidateRole = Role::firstOrCreate(['name' => 'candidate']);
        $clientRole = Role::firstOrCreate(['name' => 'client']); // Add client role

        // Assign permissions to Super Admin (ALL permissions)
        $superAdminRole->syncPermissions(Permission::all());

        // Assign permissions to Admin
        $adminRole->syncPermissions([
            'access admin dashboard',
            'access dashboard',
            
            // User management
            'view users',
            'create users',
            'edit users',
            
            // Candidate management
            'view candidates',
            'create candidates',
            'edit candidates',
            'verify candidates',
            'export candidates',
            'import candidates',
            
            // Client management (Foreign Employers)
            'view clients',
            'create clients',
            'edit clients',
            'verify clients',
            'export clients',
            
            // Document management
            'view documents',
            'upload documents',
            'verify documents',
            
            // Partner management
            'view partners',
            'create partners',
            'edit partners',
            
            // Staff management
            'view staff',
            'create staff',
            'edit staff',
            
            // Demand management
            'view demands',
            'create demands',
            'edit demands',
            'assign demands',
            
            // Application management
            'view applications',
            'process applications',
            'approve applications',
            'reject applications',
            
            // Reports
            'view reports',
            'generate reports',
            'export reports',
            
            // Contact submissions
            'view contact submissions',
            'reply to contact submissions',
            'export clients',
        ]);

        // Assign permissions to Partner
        $partnerRole->syncPermissions([
            'access dashboard',
            
            // Candidate management
            'view candidates',
            'create candidates',
            'edit candidates',
            
            // Document management
            'view documents',
            'upload documents',
            
            // Demand management
            'view demands',
            
            // Application management
            'view applications',
            
            // Reports
            'view reports',
        ]);

        // Assign permissions to Staff
        $staffRole->syncPermissions([
            'access dashboard',
            
            // Candidate management
            'view candidates',
            'verify candidates',
            
            // Document management
            'view documents',
            'verify documents',
            
            // Application management
            'view applications',
            'process applications',
            
            // Contact submissions
            'view contact submissions',
            'reply to contact submissions',
        ]);

        // Assign permissions to regular User
        $userRole->syncPermissions([
            'access dashboard',
        ]);

        // Assign permissions to Candidate
        $candidateRole->syncPermissions([
            'view own profile',
            'edit own profile',
            'view application status',
        ]);

        // Assign permissions to Client (Foreign Employer)
        $clientRole->syncPermissions([
            'view own client profile',
            'edit own client profile',
            'post job demands',
            'view applications',
        ]);

        // Create test users with roles
        $this->createTestUsers();
        
        $this->command->info('====================================');
        $this->command->info('Roles and permissions created successfully!');
        $this->command->info('====================================');
        $this->command->info('Available roles: super-admin, admin, partner, staff, user, candidate, client');
        $this->command->info('');
        $this->command->info('Test Users Created:');
        $this->command->info('------------------------------------');
        $this->command->info('Super Admin: superadmin@aspnoverseas.com / password');
        $this->command->info('Admin: admin@aspnoverseas.com / password');
        $this->command->info('Partner: partner@aspnoverseas.com / password');
        $this->command->info('Staff: staff@aspnoverseas.com / password');
        $this->command->info('User: user@aspnoverseas.com / password');
        $this->command->info('Candidate: candidate@aspnoverseas.com / password');
        $this->command->info('Client: client@aspnoverseas.com / password');
        $this->command->info('====================================');
    }
    
    private function createTestUsers()
    {
        // Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@aspnoverseas.com'],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'phone' => '+1234567890',
                'password' => bcrypt('password'),
                'is_active' => true,
            ]
        );
        $superAdmin->syncRoles(['super-admin']);
        
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@aspnoverseas.com'],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'phone' => '+1234567891',
                'password' => bcrypt('password'),
                'is_active' => true,
            ]
        );
        $admin->syncRoles(['admin']);
        
        // Partner
        $partner = User::firstOrCreate(
            ['email' => 'partner@aspnoverseas.com'],
            [
                'name' => 'Partner User',
                'username' => 'partner',
                'phone' => '+1234567892',
                'password' => bcrypt('password'),
                'is_active' => true,
            ]
        );
        $partner->syncRoles(['partner']);
        
        // Staff
        $staff = User::firstOrCreate(
            ['email' => 'staff@aspnoverseas.com'],
            [
                'name' => 'Staff User',
                'username' => 'staff',
                'phone' => '+1234567893',
                'password' => bcrypt('password'),
                'is_active' => true,
            ]
        );
        $staff->syncRoles(['staff']);
        
        // Regular User
        $user = User::firstOrCreate(
            ['email' => 'user@aspnoverseas.com'],
            [
                'name' => 'Regular User',
                'username' => 'user',
                'phone' => '+1234567894',
                'password' => bcrypt('password'),
                'is_active' => true,
            ]
        );
        $user->syncRoles(['user']);
        
        // Candidate User (for testing)
        $candidateUser = User::firstOrCreate(
            ['email' => 'candidate@aspnoverseas.com'],
            [
                'name' => 'Candidate User',
                'username' => 'candidate',
                'phone' => '+1234567895',
                'password' => bcrypt('password'),
                'is_active' => true,
            ]
        );
        $candidateUser->syncRoles(['candidate']);
        
        // Client User (Foreign Employer - for testing)
        $clientUser = User::firstOrCreate(
            ['email' => 'client@aspnoverseas.com'],
            [
                'name' => 'Client User',
                'username' => 'client',
                'phone' => '+1234567896',
                'password' => bcrypt('password'),
                'is_active' => true,
            ]
        );
        $clientUser->syncRoles(['client']);
    }
}