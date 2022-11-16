<?php

class AdminUserController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('AdminUser');
    }

    public function index()
    {
        $session = new SessionAdmin();

        if($session->getLogin()) {

            $admins = $this->model->getUsers('admins');
            $users = $this->model->getUsers('users');

            $data = [
                'titulo' => 'Administración de Usuarios',
                'menu' => false,
                'admin' => true,
                'admins' => $admins,
                'users' => $users,
            ];

            $this->view('admin/users/index', $data);
        } else {
            header('LOCATION:' . ROOT . 'admin');
        }
    }

    public function create()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $errors = [];

            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $password2 = $_POST['password2'] ?? '';

            // Expresión regular (regex) para la contraseña de administrador
            // En el if, un poco más abajo, explica lo que hace
            $pattern = '/^(?=.*\d)(?=.*[\x{0021}-\x{002b}\x{003c}-\x{0040}])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$/u';

            $dataForm = [
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ];

            if(empty($name)) {
                array_push($errors, 'El nombre de usuario es requerido');
            }

            if(empty($email)) {
                array_push($errors, 'El correo electrónico es requerido');
            }

            if(empty($password)) {
                array_push($errors, 'La clave de acceso es requerida');
            }

            /*if( ! preg_match($pattern, $password)) {
                array_push($errors, 'La contraseña debe tener al entre 8 y 16 caracteres, 
                                                    al menos un dígito, una minúscula, una mayúscula 
                                                    y un carácter no alfanumérico.');
            }*/

            if(empty($password2)) {
                array_push($errors, 'Repetir la clave de acceso es requerida');
            }

            if($password != $password2) {
                array_push($errors, 'Las claves no coinciden');
            }

            if( ! $errors) {
                if($this->model->createAdminUser($dataForm)) {
                    header('location:' . ROOT . 'adminUser');
                } else {

                    $data = [
                        'titulo' => 'Error creación administrador',
                        'menu' => false,
                        'errors' => [],
                        'subtitle' => 'Error al crear un nuevo usuario administrador',
                        'text' => 'Se ha producido un error durante el proceso de creacion de un usuario administrador',
                        'color' => 'alert-danger',
                        'url' => 'adminUser',
                        'colorButton' => 'btn-danger',
                        'textButton' => 'Volver',
                    ];

                    $this->view('mensaje', $data);
                }
            } else {

                $data = [
                    'titulo' => 'Administración de Usuarios - Alta',
                    'menu' => false,
                    'admin' => true,
                    'errors' => $errors,
                    'data' => $dataForm,
                ];

                $this->view('admin/users/create', $data);
            }
        } else {

            $data = [
                'titulo' => 'Administración de Usuarios - Alta',
                'menu' => false,
                'admin' => true,
                'data' => [],
            ];

            $this->view('admin/users/create', $data);
        }
    }

    public function update($id)
    {
        $errors = [];

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $password2 = $_POST['password2'] ?? '';
            $status = $_POST['status'] ?? '';

            if(empty($name)) {
                array_push($errors, 'El nombre de usuario es requerido');
            }

            if(empty($email)) {
                array_push($errors, 'El correo electrónico es requerido');
            }

            if(empty($status)) {
                array_push($errors, 'Seleccione un estado para el usuario');
            }

            if( ! empty($password) || ! empty($password2)) {
                if($password != $password2) {
                    array_push($errors, 'Las contraseñas no coinciden');
                }
            }

            if( ! $errors) {
                $data = [
                    'id' => $id,
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'status' => $status,
                ];

                $errors = $this->model->setUser($data);

                if( ! $errors) {
                    header('location:' . ROOT . 'adminUser');
                }
            }
        }

        $user = $this->model->getUserById($id);
        $status = $this->model->getConfig('adminStatus');

        $data = [
            'titulo' => 'Administración de Usuarios - Editar',
            'menu' => false,
            'admin' => true,
            'data' => $user,
            'status' => $status,
            'errors' => $errors,
        ];

        $this->view('admin/users/update', $data);
    }

    public function delete($id)
    {
        $errors = [];

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $errors = $this->model->delete($id);

            if( ! $errors) {
                header('location:' . ROOT . 'adminUser');
            }
        }

        $user = $this->model->getUserById($id);
        $status = $this->model->getConfig('adminStatus');

        $data = [
            'titulo' => 'Administración de Usuarios - Eliminar',
            'menu' => false,
            'admin' => true,
            'data' => $user,
            'status' => $status,
            'errors' => $errors,
        ];

        $this->view('admin/users/delete', $data);
    }
}