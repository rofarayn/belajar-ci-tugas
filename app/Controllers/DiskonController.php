<?php

namespace App\Controllers;

use App\Models\DiscountModel;

class DiskonController extends BaseController
{
    protected $discountModel;

    public function __construct()
    {
        $this->discountModel = new DiscountModel();
    }

    public function index()
    {
        // Gembok Keamanan: Tendang kembali ke Home jika bukan Admin
        if (session()->get('role') != 'admin') {
            return redirect()->to('/home');
        }

        // Ambil diskon hari ini khusus untuk header (agar tidak error)
        $hariIni = date('Y-m-d');
        $dataDiskonHariIni = $this->discountModel->where('tanggal', $hariIni)->first();
        $nominalDiskon = $dataDiskonHariIni ? $dataDiskonHariIni['nominal'] : 0;

        $data = [
            'diskon'        => $nominalDiskon, // Variabel (angka) untuk header.php
            'daftar_diskon' => $this->discountModel->findAll() // Variabel (array) untuk tabel di v_diskon.php
        ];
        
        return view('v_diskon', $data);
    }

    public function create()
    {
        // VALIDASI: Tanggal wajib unik (tidak boleh kembar di tabel discounts)
        if (!$this->validate([
            'tanggal' => [
                'rules'  => 'required|is_unique[discounts.tanggal]',
                'errors' => [
                    'is_unique' => 'The tanggal field must contain a unique value.'
                ]
            ],
            'nominal' => 'required|numeric'
        ])) {
            // Jika gagal, kembalikan ke halaman diskon bawa pesan error-nya
            return redirect()->to('/diskon')->withInput()->with('errors', $this->validator->getErrors());
        }

        // Jika lolos, simpan data
        $this->discountModel->insert([
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal'),
        ]);

        return redirect()->to('/diskon')->with('success', 'Data diskon berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Karena di form Edit inputan tanggal itu readonly, 
        // kita HANYA mengambil dan meng-update inputan 'nominal' saja.
        $this->discountModel->update($id, [
            'nominal' => $this->request->getPost('nominal')
        ]);

        return redirect()->to('/diskon')->with('success', 'Data diskon berhasil diubah.');
    }

    public function delete($id)
    {
        $this->discountModel->delete($id);
        return redirect()->to('/diskon')->with('success', 'Data diskon berhasil dihapus.');
    }
}