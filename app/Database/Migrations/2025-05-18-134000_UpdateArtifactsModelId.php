<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateArtifactsModelId extends Migration
{
    public function up()
    {
        // Drop the foreign key constraint if it exists
        $this->forge->dropForeignKey('artifacts', 'artifacts_ibfk_1');
        
        // Rename the column from model_file_id to model_id
        $this->forge->modifyColumn('artifacts', [
            'model_file_id' => [
                'name' => 'model_id',
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => null,
                'after' => 'artifact_id'
            ]
        ]);
        
        // Recreate the foreign key constraint
        $this->db->query('ALTER TABLE `artifacts` 
            ADD CONSTRAINT `artifacts_ibfk_1` 
            FOREIGN KEY (`model_id`) 
            REFERENCES `model_files` (`model_id`) 
            ON DELETE SET NULL 
            ON UPDATE CASCADE');
    }

    public function down()
    {
        // Drop the foreign key constraint
        $this->forge->dropForeignKey('artifacts', 'artifacts_ibfk_1');
        
        // Rename the column back to model_file_id
        $this->forge->modifyColumn('artifacts', [
            'model_id' => [
                'name' => 'model_file_id',
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => null,
                'after' => 'artifact_id'
            ]
        ]);
    }
}
