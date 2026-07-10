<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\DiscountModel;

class DiscountController extends ResourceController
{
   
    protected $modelName = DiscountModel::class;
    // Mengatur format balasan (response) otomatis menjadi JSON
    protected $format    = 'json';

    
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    
    public function show($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond($data);
        }
        return $this->failNotFound('Data diskon tidak ditemukan.');
    }

    
    public function create()
    {
        
        $data = $this->request->getJSON(true) ?? $this->request->getPost();

        
        if ($this->model->insert($data)) {
            $data['id'] = $this->model->getInsertID();
            return $this->respondCreated($data, 'Data diskon berhasil ditambahkan.');
        }

        // Jika gagal validasi (misal tanggal kembar), kembalikan pesan error
        return $this->failValidationErrors($this->model->errors());
    }

    
    public function update($id = null)
    {
        $data = $this->request->getJSON(true) ?? $this->request->getRawInput();

        if (!$this->model->find($id)) {
            return $this->failNotFound('Data diskon tidak ditemukan.');
        }

        if ($this->model->update($id, $data)) {
            return $this->respond([
                'status'  => 200,
                'message' => 'Data diskon berhasil diubah.',
                'data'    => $data
            ]);
        }

        return $this->failValidationErrors($this->model->errors());
    }

    
    public function delete($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            $this->model->delete($id);
            return $this->respondDeleted(['id' => $id], 'Data diskon berhasil dihapus.');
        }
        return $this->failNotFound('Data diskon tidak ditemukan.');
    }
}