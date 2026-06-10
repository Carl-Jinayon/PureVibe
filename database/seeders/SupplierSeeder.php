<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Pacific Beverages Inc.',
                'contact_person' => 'Juan Dela Cruz',
                'phone' => '+63 917 123 4567',
                'email' => 'sales@pacificbev.com',
                'address' => '123 Industrial Ave, Makati City, Metro Manila',
                'is_active' => true,
            ],
            [
                'name' => 'Golden Snacks Trading',
                'contact_person' => 'Maria Santos',
                'phone' => '+63 918 234 5678',
                'email' => 'orders@goldensnacks.com',
                'address' => '456 Commerce St, Quezon City, Metro Manila',
                'is_active' => true,
            ],
            [
                'name' => 'Metro Canned Goods Corp.',
                'contact_person' => 'Pedro Reyes',
                'phone' => '+63 919 345 6789',
                'email' => 'supply@metrocanned.com',
                'address' => '789 Warehouse Blvd, Pasig City, Metro Manila',
                'is_active' => true,
            ],
            [
                'name' => 'Arctic Frozen Foods Co.',
                'contact_person' => 'Ana Garcia',
                'phone' => '+63 920 456 7890',
                'email' => 'info@arcticfoods.com',
                'address' => '321 Cold Storage Rd, Taguig City, Metro Manila',
                'is_active' => true,
            ],
            [
                'name' => 'CleanHome Distributors',
                'contact_person' => 'Roberto Mendoza',
                'phone' => '+63 921 567 8901',
                'email' => 'orders@cleanhome.com',
                'address' => '654 Supply Chain Ave, Mandaluyong City, Metro Manila',
                'is_active' => true,
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::updateOrCreate(['name' => $supplier['name']], $supplier);
        }
    }
}
