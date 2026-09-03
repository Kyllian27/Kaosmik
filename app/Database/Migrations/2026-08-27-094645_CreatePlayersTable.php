<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePlayersTable extends Migration
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
           'user_id' => [
               'type' => 'INT',
               'constraint' => 11,
               'unsigned' => true,
           ],
           'level' => [
               'type' => 'INT',
               'constraint' => 11,
               'unsigned' => true,
               'default' => 1
           ],
            'experience' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'credits' =>[
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 1000
            ],
            'fusion_energy' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'fleet_capacity' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 10
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('players,',true);
    }

    public function down()
    {
        $this->forge->dropTable('players');
    }
}
