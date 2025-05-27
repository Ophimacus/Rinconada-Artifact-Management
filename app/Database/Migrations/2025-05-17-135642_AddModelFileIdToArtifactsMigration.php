<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddModelFileIdToArtifactsMigration extends Migration
{
    public function up()
    {
        // The model_file_id column already exists, so we only add the foreign key constraint.
        $this->db->query('ALTER TABLE artifacts ADD CONSTRAINT fk_artifacts_model_file_id FOREIGN KEY (model_file_id) REFERENCES model_files(model_id) ON DELETE SET NULL ON UPDATE CASCADE');
    }

    public function down()
    {
        // Drop foreign key constraint
        $this->forge->dropForeignKey('artifacts', 'fk_artifacts_model_file_id');
        // Drop the column (only if this migration was the one that added it)
        // $this->forge->dropColumn('artifacts', 'model_file_id');
    }
}
