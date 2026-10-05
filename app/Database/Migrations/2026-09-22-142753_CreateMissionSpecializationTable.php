<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMissionSpecializationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'mission_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'specialization_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('mission_id', 'missions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('specialization_id', 'specializations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mission_specializations');
    }

    public function down()
    {
        $this->forge->dropTable('mission_specializations');
    }
}