<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableMissionAddDuration extends Migration
{
    public function up()
    {
        $this->forge->addColumn('missions', [
            'duration' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('missions', 'duration');
    }
}
