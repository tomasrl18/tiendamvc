<?php

class AdminProductController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('AdminProduct');
    }

    public function index()
    {
        /*
         * SessionAdmin en vez de Session para hacer la distinción
         */
        $session = new SessionAdmin();

        if($session->getLogin()) {

            $products = $this->model->getProducts();
            $type = $this->model->getConfig('productType');

            $data = [
                'titulo' => 'Administración de Productos',
                'menu' => false,
                'admin' => true,
                'type' => $type,
                'products' => $products,
            ];

            $this->view('admin/products/index', $data);
        } else {
            header('location:' . ROOT . 'admin');
        }
    }

    public function create()
    {
        $errors = [];
        $dataForm = [];

        // Lista de tipos
        $typeConfig = $this->model->getConfig('productType');

        // Lista de estados
        $statusConfig = $this->model->getConfig('productStatus');

        $catalogue = $this->model->getCatalogue();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $type = $_POST['type'] ?? '';
            $name = Validate::text($_POST['name'] ?? '');
            $description = Validate::text($_POST['description'] ?? '');
            $price = Validate::number((float)($_POST['price'] ?? ''));
            $discount = Validate::number((float)($_POST['discount'] ?? ''));
            $send = Validate::number((float)($_POST['send'] ?? ''));
            $image = Validate::file($_FILES['image']['name']);
            $published = $_POST['published'] ?? '';
            $relation1 = $_POST['relation1'] != '' ? $_POST['relation1'] : 0;
            $relation2 = $_POST['relation2'] != '' ? $_POST['relation2'] : 0;
            $relation3 = $_POST['relation3'] != '' ? $_POST['relation3'] : 0;
            $mostSold = isset($_POST['mostSold']) ? '1' : '0';
            $new = isset($_POST['new']) ? '1' : '0';
            $status = $_POST['status'] ?? '';

            //Books
            $author = Validate::text($_POST['author'] ?? '');
            $publisher = Validate::text($_POST['publisher'] ?? '');
            $pages = Validate::number((int)($_POST['pages'] ?? ''));

            //Courses
            $people = $_POST['people'] ?? '';
            $objetives = $_POST['objetives'] ?? '';
            $necesites = $_POST['necesites'] ?? '';

            // Validamos la información
            if (empty($name)) {
                array_push($errors, 'El nombre del producto es requerido');
            }

            if (empty($description)) {
                array_push($errors, 'La descripción del producto es requerida');
            }

            if ( ! is_numeric($price)) {
                array_push($errors, 'El precio del producto debe de ser un número');
            }

            if ( ! is_numeric($discount)) {
                array_push($errors, 'El descuento del producto debe de ser un número');
            }

            if ( ! is_numeric($send)) {
                array_push($errors, 'Los gastos de envío del producto deben de ser numéricos');
            }

            if (is_numeric($price) && is_numeric($discount) && $price < $discount) {
                array_push($errors, 'El descuento no puede ser mayor que el precio');
            }

            if( ! empty($published)) {
                if ( ! Validate::date($published) ) {
                    array_push($errors, 'La fecha o su formato no es correcto');
                } elseif ( ! Validate::dateDif($published)) {
                    array_push($errors, 'La fecha de publicación no puede ser anterior a hoy');
                }
            } else {
                array_push($errors, 'Debe introducir una fecha de alta para el producto');
            }

            if ($type == 1) {
                if (empty($people)) {
                    array_push($errors, 'El público objetivo del curso es obligatorio');
                }

                if (empty($objetives)) {
                    array_push($errors, 'Los objetivos del curso son necesarios');
                }

                if (empty($necesites)) {
                    array_push($errors, 'Los requisitos del curso son necesarios');
                }
            }

            if ($type == 2) {
                if (empty($author)) {
                    array_push($errors, 'El autor del libro es necesario');
                }

                if (empty($publisher)) {
                    array_push($errors, 'La editorial del libro es necesaria');
                }

                if ( ! is_numeric($pages)) {
                    $pages = 0;
                    array_push($errors, 'La cantidad de páginas de un libro debe de ser un número');
                }
            } else {
                array_push($errors, 'Debes seleccionar un tipo válido');
            }

            if(empty($status)) {
                array_push($errors, 'Debe seleccionar un estado del producto');
            }

            // No refactorizado
            /*if($image){
                if (Validate::imageFile($_FILES['image']['tmp_name'])) {

                    $image = strtolower($image);

                    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                        move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $image);
                        Validate::resizeImage($image, 240);
                    } else {
                        array_push($errors, 'Error al subir el archivo de imagen');
                    }
                } else {
                    array_push($errors, 'El formato de imagen no es aceptado');
                }
            } else {
                array_push($errors, 'No se ha recibido la imagen');
            }*/

            // Refactorizado
            if($image){
                if (Validate::imageFile($_FILES['image']['tmp_name'])) {

                    $image = strtolower($image);

                    move_uploaded_file($_FILES['image']['tmp_name'], 'img/products/' . $image);
                    Validate::resizeImage($image, 240);
                } else {
                    array_push($errors, 'El formato de imagen no es aceptado');
                }
            } else {
                array_push($errors, 'No se ha recibido la imagen');
            }

            // Creamos el array de datos
            $dataForm = [
                'type'          => $type,
                'name'          => $name,
                'description'   => $description,
                'author'        => $author,
                'publisher'     => $publisher,
                'people'        => $people,
                'objetives'     => $objetives,
                'necesites'     => $necesites,
                'price'         => $price,
                'discount'      => $discount,
                'send'          => $send,
                'pages'         => $pages,
                'published'     => $published,
                'image'         => $image,
                'mostSold'      => $mostSold,
                'new'           => $new,
                'relation1'     => $relation1,
                'relation2'     => $relation2,
                'relation3'     => $relation3,
                'status'        => $status,
            ];

            if ( ! $errors ) {
                // Enviamos la información al modelo
                // $errors = $this->model->createProduct($dataForm);

                if ( $this->model->createProduct($dataForm) ) {
                    // Redirigimos al index de productos

                    header('location:' . ROOT . 'AdminProduct');
                }

                array_push($errors, 'Se ha producido un error en la inserción en la base de datos');
            }
        }

        $data = [
          'titulo' => 'Administración de productos - Alta',
          'menu' => false,
          'admin' => true,
          'type' => $typeConfig,
          'status' => $statusConfig,
          'catalogue' => $catalogue,
          'errors' => $errors,
          'data' => $dataForm,
        ];

        $this->view('admin/products/create', $data);
    }

    public function update($id)
    {
        $errors = [];

        // Lista de tipos
        $typeConfig = $this->model->getConfig('productType');

        // Lista de estados
        $statusConfig = $this->model->getConfig('productStatus');

        $catalogue = $this->model->getCatalogue();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $type = $_POST['type'] ?? '';
            $name = Validate::text($_POST['name'] ?? '');
            $description = Validate::text($_POST['description'] ?? '');
            $price = Validate::number((float)($_POST['price'] ?? ''));
            $discount = Validate::number((float)($_POST['discount'] ?? ''));
            $send = Validate::number((float)($_POST['send'] ?? ''));
            $image = Validate::file($_FILES['image']['name']);
            $published = $_POST['published'] ?? '';
            $relation1 = $_POST['relation1'] != '' ? $_POST['relation1'] : 0;
            $relation2 = $_POST['relation2'] != '' ? $_POST['relation2'] : 0;
            $relation3 = $_POST['relation3'] != '' ? $_POST['relation3'] : 0;
            $mostSold = isset($_POST['mostSold']) ? '1' : '0';
            $new = isset($_POST['new']) ? '1' : '0';
            $status = $_POST['status'] ?? '';

            //Books
            $author = Validate::text($_POST['author'] ?? '');
            $publisher = Validate::text($_POST['publisher'] ?? '');
            $pages = Validate::number((int)($_POST['pages'] ?? ''));

            //Courses
            $people = $_POST['people'] ?? '';
            $objetives = $_POST['objetives'] ?? '';
            $necesites = $_POST['necesites'] ?? '';

            // Validamos la información
            if (empty($name)) {
                array_push($errors, 'El nombre del producto es requerido');
            }

            if (empty($description)) {
                array_push($errors, 'La descripción del producto es requerida');
            }

            if (empty($price)) {
                array_push($errors, 'El precio es requerido');
            }

            if ( ! is_numeric($price)) {
                array_push($errors, 'El precio del producto debe de ser un número');
            }

            if ( ! is_numeric($discount)) {
                array_push($errors, 'El descuento del producto debe de ser un número');
            }

            if ( ! is_numeric($send)) {
                array_push($errors, 'Los gastos de envío del producto deben de ser numéricos');
            }

            if (is_numeric($price) && is_numeric($discount) && $price < $discount) {
                array_push($errors, 'El descuento no puede ser mayor que el precio');
            }

            if( ! empty($published)) {
                if ( ! Validate::date($published) ) {
                    array_push($errors, 'La fecha o su formato no es correcto');
                } elseif ( ! Validate::dateDif($published)) {
                    array_push($errors, 'La fecha de publicación no puede ser anterior a hoy');
                }
            } else {
                array_push($errors, 'Debe introducir una fecha de alta para el producto');
            }

            if ($type == 1) {
                if (empty($people)) {
                    array_push($errors, 'El público objetivo del curso es obligatorio');
                }

                if (empty($objetives)) {
                    array_push($errors, 'Los objetivos del curso son necesarios');
                }

                if (empty($necesites)) {
                    array_push($errors, 'Los requisitos del curso son necesarios');
                }
            }

            if ($type == 2) {
                if (empty($author)) {
                    array_push($errors, 'El autor del libro es necesario');
                }

                if (empty($publisher)) {
                    array_push($errors, 'La editorial del libro es necesaria');
                }

                if ( ! is_numeric($pages)) {
                    $pages = 0;
                    array_push($errors, 'La cantidad de páginas de un libro debe de ser un número');
                }

            } else {
                array_push($errors, 'Debes seleccionar un tipo válido');
            }

            /*if(empty($status)) {
                array_push($errors, 'Debe seleccionar un estado del producto');
            }*/

            if($image){
                if (Validate::imageFile($_FILES['image']['tmp_name'])) {

                    $image = strtolower($image);

                    move_uploaded_file($_FILES['image']['tmp_name'], 'img/products/' . $image);
                    Validate::resizeImage($image, 240);
                } else {
                    array_push($errors, 'El formato de imagen no es aceptado');
                }
            }

            // Creamos el array de datos
            $dataForm = [
                'id'            => $id,
                'type'          => $type,
                'name'          => $name,
                'description'   => $description,
                'author'        => $author,
                'publisher'     => $publisher,
                'people'        => $people,
                'objetives'     => $objetives,
                'necesites'     => $necesites,
                'price'         => $price,
                'discount'      => $discount,
                'send'          => $send,
                'pages'         => $pages,
                'published'     => $published,
                'image'         => $image,
                'mostSold'      => $mostSold,
                'new'           => $new,
                'relation1'     => $relation1,
                'relation2'     => $relation2,
                'relation3'     => $relation3,
                'status'        => $status,
            ];

            // If modificado el 23/10/2022. Comentado está lo viejo.
            if ( ! $errors ) {
                // Enviamos la información al modelo
                // $errors = $this->model->createProduct($dataForm);

                // Devuelve true o false
                if ($this->model->updateProduct($dataForm)) {

                    // Borrar imagen al editarla
                    /*if($image != '') {
                        Validate::deleteImage();

                        $images = scandir(URL . 'public/img/products/', 0);
                        $dbImages = $this->model->obtainImages();

                        foreach($images as $img)
                        {
                            if( ! in_array($img, $dbImages)) {
                                // Delete file
                                unlink('img/products/' . $img);

                                //print("Deleted file [". $img ."]\n");
                            }
                        }
                        unset($img);
                    }*/

                    header('location:' . ROOT . 'AdminProduct');
                }

                // Si va bien el método devuelve un array vacío
                /*if ( count($this->model->updateProduct($dataForm)) == 0 ) {
                    // Redirigimos al index de productos

                    header('location:' . ROOT . 'AdminProduct');
                }*/

                array_push($errors, 'Se ha producido un error en la inserción en la base de datos');
            }
        }

        // Obtención del producto desde memoria, es un array con la info del producto
        $product = $this->model->getProductById($id);

        $data = [
            'titulo' => 'Administración de productos - Edición',
            'menu' => false,
            'admin' => true,
            'type' => $typeConfig,
            'status' => $statusConfig,
            'catalogue' => $catalogue,
            'errors' => $errors,
            'product' => $product,
        ];

        $this->view('admin/products/update', $data);
    }

    public function delete($id)
    {
        //$errors = [];

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$errors = $this->model->delete($id);

            /*if(empty($errors)) {
                header('location' . ROOT . 'AdminProduct');
            }*/

            if($this->model->delete($id)) {
                header('location:' . ROOT . 'AdminProduct');
            }
        }

        $product = $this->model->getProductById($id);
        $typeConfig = $this->model->getConfig('productType');

        $data = [
            'titulo' => 'Administración de productos - Borrado',
            'menu' => false,
            'admin' => true,
            'type' => $typeConfig,
            'product' => $product,
        ];

        $this->view('admin/products/delete', $data);
    }
}