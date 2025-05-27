<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInitialTables extends Migration
{
    public function up()
    {
        // Create models table
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'detailed_description' => [
                'type' => 'LONGTEXT',
                'null' => true
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'thumbnail_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'scale_default' => [
                'type' => 'JSON',
                'null' => true
            ],
            'metadata' => [
                'type' => 'JSON',
                'null' => true
            ],
            'artist_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'creation_date' => [
                'type' => 'DATE',
                'null' => true
            ],
            'period' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'style' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'medium' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'dimensions' => [
                'type' => 'JSON',
                'null' => true
            ],
            'condition' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'conservation_status' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'cultural_significance' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'current_location' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'original_location' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'acquisition_date' => [
                'type' => 'DATE',
                'null' => true
            ],
            'provenance' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'exhibition_history' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'scan_date' => [
                'type' => 'DATE',
                'null' => true
            ],
            'scan_technology' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'scan_resolution' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'file_size' => [
                'type' => 'BIGINT',
                'null' => true
            ],
            'file_format' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],
            'polygon_count' => [
                'type' => 'INT',
                'null' => true
            ],
            'texture_resolution' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'copyright_holder' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'license_type' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'usage_restrictions' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'public_access' => [
                'type' => 'BOOLEAN',
                'default' => true
            ],
            'tags' => [
                'type' => 'JSON',
                'null' => true
            ],
            'keywords' => [
                'type' => 'JSON',
                'null' => true
            ],
            'related_works' => [
                'type' => 'JSON',
                'null' => true
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'created_by' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true
            ],
            'updated_by' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('models');

        // Create locations table
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'country' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'coordinates' => [
                'type' => 'JSON',
                'null' => true
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],
            'contact_info' => [
                'type' => 'JSON',
                'null' => true
            ],
            'website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('locations');

        // Create artists table
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'biography' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'birth_date' => [
                'type' => 'DATE',
                'null' => true
            ],
            'death_date' => [
                'type' => 'DATE',
                'null' => true
            ],
            'nationality' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'period' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'style' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'notable_works' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'bibliography' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('artists');

        // Create users table
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'is_admin' => [
                'type' => 'BOOLEAN',
                'default' => false
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('models');
        $this->forge->dropTable('locations');
        $this->forge->dropTable('artists');
        $this->forge->dropTable('users');
    }
} 