<?php

class SearchController extends Controller
{
  private $model;

    public function __construct()
    {
       $this->model = $this->model('Search'); 
    }

    public function products()
    {
        $search = trim(Validate::text($_POST['search'] ?? ''));

        // Validar lo que venga

        if($search != '') {
            $dataSearch = $this->model->getProducts($search);

            $data = [
                'titulo' => 'Buscador de productos',
                'subtitle' => 'Resultado de la búsqueda',
                'data' => $dataSearch,
                'menu' => true,
            ];

            $this->view('search/search', $data);
        } else {
            // Redirige al index de shop, porque pusimos que si estaba logueado redirigía al index de shop
            header('location:' . ROOT);
        }
    }
}