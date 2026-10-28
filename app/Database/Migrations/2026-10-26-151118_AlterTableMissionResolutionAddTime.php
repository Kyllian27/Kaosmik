<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlerTableMissionResolutionAddTime extends Migration
{
    public function up()
    {
        $this->forge->addColumn('mission_resolutions', [
            'ends_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'resolved_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);

        $this->db->table('mission_resolutions')
            ->set('ends_at', 'created_at',false)
            ->set('resolved_at', 'created_at',false)
            ->update();
    }

    public function down()
    {
        $this->forge->dropColumn('mission_resolutions', 'ends_at');
        $this->forge->dropColumn('mission_resolutions', 'resolved_at');
    }
}
