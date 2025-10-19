<?php
// database/seeders/WebsiteDataSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyInformation;
use App\Models\ServiceProduct;

class WebsiteDataSeeder extends Seeder
{
    public function run(): void
    {
        // Company Information
        CompanyInformation::create([
            'company_name' => 'Rozwel Control Pvt. Ltd.',
            'tagline' => 'Complete Business Management Solutions',
            'about' => 'Rozwel Control is a leading provider of comprehensive business management solutions...',
            'mission' => 'To empower businesses with innovative technology solutions...',
            'vision' => 'To be the preferred partner for business automation...',
            'address' => '123 Business District, Industrial Area, City, State 12345',
            'phone' => '+1 (555) 123-4567',
            'email' => 'info@rozwelcontrol.com',
            'website' => 'https://rozwelcontrol.com',
            'working_hours' => 'Mon - Fri: 9:00 AM - 6:00 PM',
        ]);

        // Service Products
        $products = [
            [
                'name' => 'Inventory Management System',
                'slug' => 'inventory-management',
                'description' => 'Complete inventory tracking with real-time stock updates...',
                'features' => json_encode(['Real-time stock tracking', 'Automated purchase orders', 'Low stock alerts']),
                'monthly_price' => 499.00,
                'yearly_price' => 4990.00,
                'icon' => 'fas fa-boxes',
                'color' => 'blue',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            // ... other products
        ];

        foreach ($products as $product) {
            ServiceProduct::create($product);
        }
    }
}