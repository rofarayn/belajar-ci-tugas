<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class PembelianController extends BaseController
{
    protected $transactionModel;
    protected $transactionDetailModel;

    public function __construct()
    {
        helper(['number', 'form']);
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
    }

    public function index()
    {
        
        if (session()->get('role') != 'admin') {
            return redirect()->to('/home');
        }

       
        $transactions = $this->transactionModel->findAll();
        $transactionIds = array_column($transactions, 'id');

        
        $products = [];
        if (!empty($transactionIds)) {
            $products = $this->transactionDetailModel->getProductsByTransactionIds($transactionIds);
        }

        $data = [
            'transactions' => $transactions,
            'products'     => $products
        ]; 

        return view('v_pembelian', $data);
    }

    public function ubah_status($id)
    {
        
        if (session()->get('role') != 'admin') {
            return redirect()->to('/home');
        }

        
        $transaksi = $this->transactionModel->find($id);

        if ($transaksi) {
            
            $statusBaru = ($transaksi['status'] == 0) ? 1 : 0;
            
            
            $this->transactionModel->update($id, ['status' => $statusBaru]);
            
            return redirect()->to('/pembelian')->with('success', 'Status pesanan berhasil diubah.');
        }

        return redirect()->to('/pembelian')->with('error', 'Data tidak ditemukan.');
    }
}