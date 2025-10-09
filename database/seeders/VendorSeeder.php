<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorSeeder extends Seeder
{
    public function run()
    {
        $vendors = [
            [
                'name' => 'Electro Components Ltd.',
                'contact_person' => 'John Smith',
                'email' => 'john@electro.com',
                'phone' => '+1-555-0101',
                'address' => '123 Electronics Street, Tech City'
            ],
            [
                'name' => 'Mech Parts Inc.',
                'contact_person' => 'Sarah Johnson',
                'email' => 'sarah@mechparts.com',
                'phone' => '+1-555-0102',
                'address' => '456 Mechanical Ave, Industry Park'
            ],
            [
                'name' => 'Power Systems Co.',
                'contact_person' => 'Mike Brown',
                'email' => 'mike@powersystems.com',
                'phone' => '+1-555-0103',
                'address' => '789 Electric Road, Power Zone'
            ],
            [
                'name' => 'Plastic World',
                'contact_person' => 'Lisa Davis',
                'email' => 'lisa@plasticworld.com',
                'phone' => '+1-555-0104',
                'address' => '321 Polymer Street, Material District'
            ],
            [
                'name' => 'Metal Works Ltd.',
                'contact_person' => 'Robert Wilson',
                'email' => 'robert@metalworks.com',
                'phone' => '+1-555-0105',
                'address' => '654 Steel Avenue, Forge Town'
            ]
        ];

        foreach ($vendors as $vendor) {
            Vendor::create($vendor);
        }
    }
}