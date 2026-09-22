<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMissionTable extends Migration
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
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null'=> false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null'=> true,
            ],
            'level_required' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null'=> false,
            ],
            'power_required_min' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null'=> false,
            ],
            'power_required_max' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null'=> false,
            ],
            'stamina_cost_min' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null'=> false,
            ],
            'stamina_cost_max' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null'=> false,
            ],
            'credits_reward_min'=> [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null'=> false,
            ],
            'credits_reward_max' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null'=> false,
            ],
            'energy_reward_min' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null'=> false,
            ],
            'energy_reward_max' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null'=> false,
            ],
            'exeperience_reward_min' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null'=> false,
            ],
            'exeperience_reward_max' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null'=> false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null'=> true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null'=> true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null'=> true,
            ]
        ]);
        $this->forge->addPrimaryKey('id', true);
        $this->forge->createTable('mission_template', true);
    }

    public function down()
    {
        $this->forge->dropTable('mission_template');
    }
}
