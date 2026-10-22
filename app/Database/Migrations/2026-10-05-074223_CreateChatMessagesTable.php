<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChatMessagesTable extends Migration
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
            'id_sender' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_receiver' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'message' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id', );
        $this->forge->addForeignKey('id_sender', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_receiver', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('chat_messages');
    }

    public function down()
    {
        $this->forge->dropTable('chat_messages');
    }
}