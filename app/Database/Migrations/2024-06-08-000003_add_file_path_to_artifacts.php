<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFilePathToArtifacts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('artifacts', [
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'created_at',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('artifacts', 'file_path');
    }
} 