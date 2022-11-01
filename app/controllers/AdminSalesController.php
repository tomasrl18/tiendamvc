<?php

class AdminSalesController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('AdminSales');
    }

    public function index()
    {
        $session = new SessionAdmin();

        if($session->getLogin()) {

            $sales = $this->model->show();
            //$carts = $this->model->groupCarts($sales);
            //$products = $this->model->ahoraPiensoUnNombre();

            $data = [
                'titulo' => 'Bienvenid@ a la administración de ventas',
                'subtitle' => 'Administración de Ventas',
                'menu' => false,
                'admin' => true,
                'data' => $sales,
                //'products' => $products,
                //'data' => $carts,
            ];

            $this->view('admin/sales/index', $data);
        } else {
            header('LOCATION:' . ROOT . 'admin');
        }
    }
}