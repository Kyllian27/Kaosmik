<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRarityLevelsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'color' => [
                'type'       => 'VARCHAR',
                'constraint' => 7,
                'null'       => false,
            ],
            'power_multiplier' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => false,
            ],
            'cost_multiplier' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => false,
                'default'    => 1.00,
            ],
            'appearance_rate' => [
                'type'       => 'DECIMAL',
                'constraint' => '7,4',
                'null'       => false,
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
        $this->forge->createTable('rarity_levels', true);

        $this->db->table('rarity_levels')->insert([
            'name'             => 'commun',
            'color'            => '#0000FF',
            'power_multiplier' => 1.00,
            'cost_multiplier'  => 1.00,
            'appearance_rate'  => 100.0000,
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s')
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('rarity_levels', true);
    }
}