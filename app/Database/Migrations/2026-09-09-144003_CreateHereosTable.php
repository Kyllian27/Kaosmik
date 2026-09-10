<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHeroesTable extends Migration
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
            ],
            'hero_model_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'rarity_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'power' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'cost_credit' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'stamina_current' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 100,
            ],
            'stamina_max' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 100,
            ],
            'last_stamina_update' => [
                'type' => 'DATETIME',
                'null' => true,
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
        $this->forge->addForeignKey('hero_model_id', 'hero_models', 'id');
        $this->forge->addForeignKey('rarity_id', 'rarity_levels', 'id');
        $this->forge->createTable('heroes');
    }

    public function down()
    {
        $this->forge->dropTable('heroes');
    }
}