<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialData extends Seeder
{
    public function run()
    {
        // Sample Artists
        $artists = [
            [
                'name' => 'Leonardo da Vinci',
                'biography' => 'Italian Renaissance polymath whose areas of interest included invention, drawing, painting, sculpture and architecture.',
                'nationality' => 'Italian',
                'period' => 'Renaissance',
                'style' => 'High Renaissance',
                'notable_works' => json_encode(['Mona Lisa', 'The Last Supper', 'Vitruvian Man']),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Michelangelo',
                'biography' => 'Italian sculptor, painter, architect and poet of the High Renaissance.',
                'nationality' => 'Italian',
                'period' => 'Renaissance',
                'style' => 'High Renaissance',
                'notable_works' => json_encode(['David', 'Sistine Chapel ceiling', 'Pietà']),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert Artists
        $this->db->table('artists')->insertBatch($artists);

        // Sample Artifacts
        $artifacts = [
            [
                'title' => 'David Statue',
                'description' => 'High-resolution 3D scan of Michelangelo\'s David',
                'origin' => 'Italy',
                'municipality' => 'Florence',
                'category_id' => 1,
                'artist_id' => 1,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Vitruvian Man',
                'description' => '3D interpretation of Leonardo\'s famous drawing',
                'origin' => 'Italy',
                'municipality' => 'Venice',
                'category_id' => 1,
                'artist_id' => 2,
                'user_id' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert Artifacts
        $this->db->table('artifacts')->insertBatch($artifacts);

        // Seed default admin user
        $adminUser = [
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'is_admin' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->db->table('users')->insert($adminUser);
    }
} 