<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\DiscountModel;

class Home extends BaseController
{
    protected $productModel;
    protected $discountModel;

    function __construct(){
        helper(['number', 'form']);
        $this->productModel = new ProductModel();
        $this->discountModel = new DiscountModel(); 
    }

    public function index()
    {
        // Mengecek apakah ada diskon untuk tanggal hari ini
        $hariIni = date('Y-m-d');
        $dataDiskon = $this->discountModel->where('tanggal', $hariIni)->first();
        
        // Jika ada, ambil nominalnya. Jika tidak ada, atur jadi 0.
        $nominalDiskon = $dataDiskon ? $dataDiskon['nominal'] : 0;

        return view('v_home', [
            'products' => $this->productModel->findAll(),
            'diskon'   => $nominalDiskon // Mengirim variabel diskon ke View
        ]);
    }
}