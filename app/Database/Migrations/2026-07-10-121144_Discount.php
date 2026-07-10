<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Discount extends Migration
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
            'tanggal' => [
                'type' => 'DATE',
            ],
            'nominal' => [
                'type' => 'DOUBLE',
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

        // Menentukan primary key
        $this->forge->addKey('id', true);

        // Membuat tabel dengan nama 'discounts' (atau sesuaikan dengan kebutuhanmu)
        $this->forge->createTable('discounts');
    }

    public function down()
    {
        // Menghapus tabel jika melakukan rollback
        $this->forge->dropTable('discounts');
    }
}