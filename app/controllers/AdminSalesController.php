<?php

class AdminSalesController extends Controller
{
    public function index()
    {
        $session = new SessionAdmin();

        if($session->getLogin()) {

            $data = [
                'titulo' => 'Bienvenid@ a la administración de ventas',
                'menu' => false,
                'admin' => true,
                'subtitle' => 'Administración de ventas',
            ];

            $this->view('admin/sales/index', $data);

        } else {
            header('LOCATION:' . ROOT . 'admin');
        }
    }
}