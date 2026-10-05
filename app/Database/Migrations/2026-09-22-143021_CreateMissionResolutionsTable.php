<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMissionResolutionsTable extends Migration
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
            'player_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'mission_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'success' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'credits_gained' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0,
            ],
            'energy_gained' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('player_id', 'players', 'id');
        $this->forge->addForeignKey('mission_id', 'missions', 'id');
        $this->forge->createTable('mission_resolutions');
    }

    public function down()
    {
        $this->forge->dropTable('mission_resolutions');
    }
}