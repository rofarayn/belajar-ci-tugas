<?php

namespace App\Models;

use CodeIgniter\Model;

class DiscountModel extends Model
{
    protected $table            = 'discounts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // 1. Aktifkan Soft Deletes karena kita punya kolom deleted_at
    protected $useSoftDeletes   = true; 
    
    protected $protectFields    = true;
    
    // 2. Daftarkan kolom yang boleh diisi/diubah melalui model
    protected $allowedFields    = ['tanggal', 'nominal']; 

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    // 3. Aktifkan Timestamps otomatis untuk created_at dan updated_at
    protected $useTimestamps = true; 
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    // 4. Terapkan aturan validasi untuk mencegah tanggal kembar saat input baru
    protected $validationRules      = [
        'tanggal' => 'required|valid_date|is_unique[discounts.tanggal,id,{id}]',
        'nominal' => 'required|numeric'
    ];
    
    // Kustomisasi pesan error jika validasi gagal (opsional tapi biar informatif)
    protected $validationMessages   = [
        'tanggal' => [
            'required'  => 'Tanggal diskon wajib diisi.',
            'is_unique' => 'Diskon untuk tanggal tersebut sudah ada, tidak boleh duplikat!'
        ],
        'nominal' => [
            'required' => 'Nominal diskon wajib diisi.',
            'numeric'  => 'Nominal harus berupa angka.'
        ]
    ];
    
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}