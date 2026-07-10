<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiscountSeeder extends Seeder
{
    public function run()
    {
        // Contoh nominal variasi seperti di gambar soal
        $nominalVariasi = [100000, 100000, 200000, 150000, 250000, 300000, 300000, 300000, 300000, 300000];

        for ($i = 0; $i < 10; $i++) {
            // Membuat tanggal bertambah 1 hari setiap perulangan (hari ini, besok, lusa, dst.)
            $tanggal = date("Y-m-d", strtotime("+$i day"));

            $data = [
                'tanggal'    => $tanggal,
                'nominal'    => $nominalVariasi[$i],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => null,
                'deleted_at' => null,
            ];

            // Insert satu per satu ke tabel 'discounts' menggunakan model looping kamu
            $this->db->table('discounts')->insert($data);
        }
    }
}