<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Module;
use App\Models\Submodule;
use App\Models\System;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Companies
        $schnee = Company::create([
            'name' => 'Schnee Dust Company',
            'code' => 'SCHNEE',
            'primary_color' => '#E8F4F8',
            'accent_color' => '#5DADE2',
			'logo_url' => 'https://static.wikia.nocookie.net/tales-of-rwby-encyclopedia/images/6/63/Schnee_Dust_Company_Emblem.png'
        ]);

        $mistral = Company::create([
            'name' => 'White Fang Group',
            'code' => 'WHITEFANG',
            'primary_color' => '#2C3E50',
            'accent_color' => '#E74C3C',
            'logo_url' => 'https://static.wikia.nocookie.net/tales-of-rwby-encyclopedia/images/b/b2/White_Fang_v2.png'
		]);
		
        $generic = Company::create([
            'name' => 'Generic Corp',
            'code' => 'GENERIC',
            'primary_color' => '#3490dc',
            'accent_color' => '#ffcc00',
        ]);

        // Create Users
        $weiss = User::create([
            'username' => 'weissschnee',
            'email' => 'weiss@schnee.com',
            'password' => Hash::make('Passw0rd!'),
            'full_name' => 'Weiss Schnee',
            'company_id' => $schnee->id,
            'is_active' => true,
        ]);

        $adam = User::create([
            'username' => 'Adam',
            'email' => 'adam@mistral.com',
            'password' => Hash::make('Passw0rd!'),
            'full_name' => 'Adam Taurus',
            'company_id' => $mistral->id,
            'is_active' => true,
        ]);

        $testUser = User::create([
            'username' => 'testuser',
            'email' => 'test@generic.com',
            'password' => Hash::make('Passw0rd!'),
            'full_name' => 'Test User',
            'company_id' => $generic->id,
            'is_active' => true,
        ]);

        // Create Systems
        $adminSystem = System::create([
            'name' => 'Administration',
            'code' => 'ADMIN',
        ]);

        $salesSystem = System::create([
            'name' => 'Sales & Marketing',
            'code' => 'SALES',
        ]);

        // Admin System Modules
        $userManagement = Module::create([
            'system_id' => $adminSystem->id,
            'name' => 'User Management',
            'code' => 'USER_MGMT',
            'icon' => 'users',
        ]);

        $companySettings = Module::create([
            'system_id' => $adminSystem->id,
            'name' => 'Company Settings',
            'code' => 'COMPANY_SETTINGS',
            'icon' => 'settings',
        ]);

        $reports = Module::create([
            'system_id' => $adminSystem->id,
            'name' => 'Reports',
            'code' => 'REPORTS',
            'icon' => 'file-text',
        ]);

        // Sales System Modules
        $customers = Module::create([
            'system_id' => $salesSystem->id,
            'name' => 'Customer Management',
            'code' => 'CUSTOMERS',
            'icon' => 'user-check',
        ]);

        $orders = Module::create([
            'system_id' => $salesSystem->id,
            'name' => 'Order Processing',
            'code' => 'ORDERS',
            'icon' => 'shopping-cart',
        ]);

        $inventory = Module::create([
            'system_id' => $salesSystem->id,
            'name' => 'Inventory',
            'code' => 'INVENTORY',
            'icon' => 'package',
        ]);

        // User Management Submodules
        $usersList = Submodule::create([
            'module_id' => $userManagement->id,
            'name' => 'Users List',
            'code' => 'USERS_LIST',
            'route' => '/users',
        ]);

        $userRoles = Submodule::create([
            'module_id' => $userManagement->id,
            'name' => 'User Roles',
            'code' => 'USER_ROLES',
            'route' => '/users/roles',
        ]);

        // Company Settings Submodules
        $companyProfile = Submodule::create([
            'module_id' => $companySettings->id,
            'name' => 'Company Profile',
            'code' => 'COMPANY_PROFILE',
            'route' => '/company/profile',
        ]);

        $branding = Submodule::create([
            'module_id' => $companySettings->id,
            'name' => 'Branding',
            'code' => 'BRANDING',
            'route' => '/company/branding',
        ]);

        // Reports Submodules
        $salesReports = Submodule::create([
            'module_id' => $reports->id,
            'name' => 'Sales Reports',
            'code' => 'SALES_REPORTS',
            'route' => '/reports/sales',
        ]);

        $userActivity = Submodule::create([
            'module_id' => $reports->id,
            'name' => 'User Activity',
            'code' => 'USER_ACTIVITY',
            'route' => '/reports/activity',
        ]);

        // Customer Management Submodules
        $customerList = Submodule::create([
            'module_id' => $customers->id,
            'name' => 'Customer List',
            'code' => 'CUSTOMER_LIST',
            'route' => '/customers',
        ]);

        $customerSegments = Submodule::create([
            'module_id' => $customers->id,
            'name' => 'Customer Segments',
            'code' => 'CUSTOMER_SEGMENTS',
            'route' => '/customers/segments',
        ]);

        // Order Processing Submodules
        $orderList = Submodule::create([
            'module_id' => $orders->id,
            'name' => 'Order List',
            'code' => 'ORDER_LIST',
            'route' => '/orders',
        ]);

        $orderTracking = Submodule::create([
            'module_id' => $orders->id,
            'name' => 'Order Tracking',
            'code' => 'ORDER_TRACKING',
            'route' => '/orders/tracking',
        ]);

        // Inventory Submodules
        $stockLevels = Submodule::create([
            'module_id' => $inventory->id,
            'name' => 'Stock Levels',
            'code' => 'STOCK_LEVELS',
            'route' => '/inventory/stock',
        ]);

        $warehouseManagement = Submodule::create([
            'module_id' => $inventory->id,
            'name' => 'Warehouse Management',
            'code' => 'WAREHOUSE_MGMT',
            'route' => '/inventory/warehouse',
        ]);

        // Assign Permissions to Weiss (Full Admin Access)
        $weiss->submodules()->attach([
            $usersList->id,
            $userRoles->id,
            $companyProfile->id,
            $branding->id,
            $salesReports->id,
            $userActivity->id,
            $customerList->id,
            $customerSegments->id,
            $orderList->id,
            $orderTracking->id,
        ]);

        // Assign Permissions to Adam (Sales & Inventory Focus)
        $adam->submodules()->attach([
            $customerList->id,
            $orderList->id,
            $orderTracking->id,
            $stockLevels->id,
            $warehouseManagement->id,
            $salesReports->id,
        ]);

        // Assign Permissions to Test User (Limited Access)
        $testUser->submodules()->attach([
            $customerList->id,
            $orderList->id,
        ]);
    }
}