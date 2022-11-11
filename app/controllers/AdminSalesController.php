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

            $data = [
                'titulo' => 'Bienvenid@ a la administración de ventas',
                'subtitle' => 'Administración de Ventas',
                'menu' => false,
                'admin' => true,
                'data' => $sales,
            ];

            $this->view('admin/sales/index', $data);
        } else {
            header('LOCATION:' . ROOT . 'admin');
        }
    }

    // Pensar otro nombre
    public function findByDate()
    {
        $errors = [];
        $dataForm = [];
        $sales = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $date1 = $_POST['date1'] ?? '';
            $date2 = $_POST['date2'] ?? '';

            if($date1 == '' && $date2 == '') {
                $sales = $this->model->show();

                $data = [
                    'titulo' => 'Bienvenid@ a la administración de ventas',
                    'subtitle' => 'Administración de Ventas',
                    'menu' => false,
                    'admin' => true,
                    'errors' => $errors,
                    'data' => $sales,
                ];

                $this->view('admin/sales/index', $data);
            }

            if($date1 == '') {
                array_push($errors, 'Es necesario introducir dos fechas');
            }

            if($date2 == '') {
                array_push($errors, 'Es necesario introducir dos fechas');
            }

            if($date2 <= $date1) {
                array_push($errors, 'La segunda fecha no puede ser menor o igual a la primera fecha');
            }

            if(count($errors) > 0) {
                $sales = $this->model->show();

                $data = [
                    'titulo' => 'Bienvenid@ a la administración de ventas',
                    'subtitle' => 'Administración de Ventas',
                    'menu' => false,
                    'admin' => true,
                    'errors' => $errors,
                    'data' => $sales,
                ];

                $this->view('admin/sales/index', $data);
            } else {
                $dataForm = [
                    'date1' => $date1,
                    'date2' => $date2,
                ];

                $sales = $this->model->findSalesByData($dataForm);

                $data = [
                    'titulo' => 'Bienvenid@ a la administración de ventas',
                    'subtitle' => 'Administración de Ventas',
                    'menu' => false,
                    'admin' => true,
                    'data' => $sales,
                    'dataForm' => $dataForm,
                ];

                $this->view('admin/sales/date', $data);
            }
        }

        /*$data = [
            'titulo' => 'Bienvenid@ a la administración de ventas',
            'subtitle' => 'Administración de Ventas',
            'menu' => false,
            'admin' => true,
            'data' => $sales,
            'dataForm' => $dataForm,
        ];

        $this->view('admin/sales/date', $data);*/
    }

    /*public function findByID()
    {
        $errors = [];
        $dataForm = [];
        $sales = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? '';

            if($id = '') {
                $sales = $this->model->show();

                $data = [
                    'titulo' => 'Bienvenid@ a la administración de ventas',
                    'subtitle' => 'Administración de Ventas',
                    'menu' => false,
                    'admin' => true,
                    'errors' => $errors,
                    'data' => $sales,
                ];

                $this->view('admin/sales/index', $data);
            }

            if( ! $this->model->validateID($id)) {
                array_push($errors, 'El id introducido no existe en la base de datos');
            }

            if( ! is_numeric($id)) {
                array_push($errors, 'El id debe ser un número');
            }

            if($id < 0) {
                array_push($errors, 'Introduzca un id válido');
            }

            if(count($errors) > 0) {
                $sales = $this->model->show();

                $data = [
                    'titulo' => 'Bienvenid@ a la administración de ventas',
                    'subtitle' => 'Administración de Ventas',
                    'menu' => false,
                    'admin' => true,
                    'errors' => $errors,
                    'data' => $sales,
                ];

                $this->view('admin/sales/index', $data);
            } else {
                $dataForm = [ 'id' => $id, ];

                $sales = $this->model->findSalesByID($dataForm);

                $data = [
                    'titulo' => 'Bienvenid@ a la administración de ventas',
                    'subtitle' => 'Administración de Ventas',
                    'menu' => false,
                    'admin' => true,
                    'data' => $sales,
                    'dataForm' => $dataForm,
                ];

                $this->view('admin/sales/date', $data);
            }
        }
    }*/
}