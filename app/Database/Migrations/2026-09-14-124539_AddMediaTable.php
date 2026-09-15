<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMediasTable extends Migration
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
            'entity_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'entity_type' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => false,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'url' => [
                'type' => 'TEXT',
            ],
            'alt' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
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
        $this->forge->createTable('medias');
    }

    public function down()
    {
        $this->forge->dropTable('medias');
    }
}